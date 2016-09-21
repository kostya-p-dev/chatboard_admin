<?php

namespace ErmineApp\AdminBundle\Twig;


use ErmineApp\UserBundle\Entity\FriendsRepository;
use ErmineApp\UserBundle\Entity\NotificationRepository;
use ErmineApp\UserBundle\Entity\User;
use ErmineApp\UserBundle\Entity\UserRepository;
use ErmineApp\UserBundle\Service\GoogleManager;
use ErmineApp\UserBundle\Service\UserManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AdminExtension extends \Twig_Extension
{
    protected $userRepo;
    protected $userManager;

    public function __construct(
                                UserRepository $userRepo,
                                UserManager $userManager
    )
    {
        $this->userRepo = $userRepo;
        $this->userManager = $userManager;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sortTimes', array($this, 'sortTimes')),
            new \Twig_SimpleFilter('convertUnixToAge', array($this, 'convertUnixToAge')),
            new \Twig_SimpleFilter('getTimeZone', array($this, 'getTimeZone')),
            new \Twig_SimpleFilter('getUserInfo', array($this, 'getUserInfo')),
            new \Twig_SimpleFilter('getUserStat', array($this, 'getUserStat'))
        );
    }

    /**
     * getFollowingActivities
     * @param $user
     * @return array
     */
    public function getFollowingActivities($user)
    {
        $activities = $this->activityRepo->findMyFollowingActivities($user);
        return $activities;
    }

    /**
     * convertUnixToAge
     * @param $unix
     * @return float|int|string
     */
    public function convertUnixToAge($unix)
    {
        $age = $this->userManager->unixToAge($unix);
        return $age;
    }

    /**
     * sortTimes
     * @param Activities $activity
     * @return array
     */
    public function sortTimes(Activities $activity)
    {
        $defaultTimes = [];
        foreach(['100','101','102','104',] as $k => $timeTypes){
            $defaultTime = new ActivitiesTimes();
            $date = new \DateTime('now');
            $result = $date->format('H:00:00');
            $defaultTime
                ->setEventTime($date)
                ->setEventTimeUnix(strtotime($result))
                ->setEventDateUnix(strtotime($result))
                ->setType($timeTypes)
                ->setEnable(0)
                ->setActivities($activity)
                ->setDays('[]')
                ->setIsUsed(false)
            ;
            $defaultTimes[$timeTypes] = $defaultTime;
        }

        if(count($activitiesTimes = $activity->getActivitiesTimes()) > 0){
            /** @var ActivitiesTimes $at */
            foreach($activitiesTimes as $at){
                if(array_key_exists($at->getType(), $defaultTimes)){
                    $defaultTimes[$at->getType()] = $at;
                }
            }
        }
        return $defaultTimes;
    }

    /**
     * getTimezone
     * @param $foo
     * @param $lat
     * @param $lng
     * @return string
     */
    public function getTimeZone($foo, $lat, $lng){
        if(!$timeZone = $this->googleManager->getTimeZone($foo, $lat, $lng)){
            $timeZone = [
                'id'     => 'Europe/London',
                'hour'   => '+00',
                'minute' => '00'
            ];
        }else{
            $timeZone = $timeZone;
        }
        return $timeZone;
    }

    /**
     * getUserInfo
     * @return mixed
     */
    public function getUserInfo(){
        $users =  $this->userRepo->getUserInfo();
        return $users;
    }

    /**
     * getUserStat
     * @return mixed
     */
    public function getUserStat(){
        /* LAST MONTH */

        $userStatMonthAgo =  $this->userRepo->getStatByMonthsBifore();
        $dateMonthAgo = new \DateTime('now - 1 month');
        $dateMonthAgo =explode('|', $dateMonthAgo->format('d|t|M'));
        $monthInfo = [
            'from' => $dateMonthAgo[0],
            'to' => $dateMonthAgo[1],
            'monthNum' => $dateMonthAgo[2]
        ];
        $res1 = $this->fillEmptyDays($userStatMonthAgo, $monthInfo);

        /* CURRENT MONTH */

        $userStat =  $this->userRepo->getStatByMonths();
        $dateCurrent = new \DateTime('now');
        $dateCurrent =explode('|', $dateCurrent->format('d|t|M'));

        $monthInfo2 = [
            'from' => "1",
            'to' => $dateCurrent[0],
            'monthNum' => $dateCurrent[2]
        ];
        $res2 = $this->fillEmptyDays($userStat, $monthInfo2);

        /* BOTH MONTHS */

        $allData  = $res1;
        foreach($res2 as $k => $v){
            $allData [] = $v;
        }
        return $allData;
    }

    /**
     * @param $statData
     * @param $monthInfo current day num and sum days in month
     *
     * @return array
     */
    public function fillEmptyDays($statData, $monthInfo){
        $monthName = $monthInfo['monthNum'];
        $data = [];
        foreach($statData as $k => $v){
            $data[$v['dayName']] = $v;
        }
        $res = [];
        for($i = $monthInfo['from']; $i <= $monthInfo['to']; $i++){
            if($i < 10){
                $index = '0'.$i;
            }else{
                $index  =$i;
            }

            if(array_key_exists($index, $data)){
                $data[$index]['dayName'] =  $index == '01' ? $monthName/*.' - '.$index */: $index;
                $res [] = $data[$index];
            }else{
                $res [] = [
                    'userCount' => 0,
                    'yearName' => 0,
                    'monthName' => '',
                    'dayName' => $d = $index == '01' ? $monthName : $index
                ];
            }
        }
        return $res;
    }

    public function getName()
    {
        return 'admin_extension';
    }
}