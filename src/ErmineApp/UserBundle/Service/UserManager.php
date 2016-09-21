<?php

namespace ErmineApp\UserBundle\Service;

use ErmineApp\SocialNetsBundle\Service\SocAPIAdapter\SocialNetAdapter;
use ErmineApp\SocialNetsBundle\Service\SocNetManager;
use ErmineApp\UserBundle\Entity\Session;
use ErmineApp\UserBundle\Entity\SessionRepository;
use ErmineApp\UserBundle\Entity\User;
use ErmineApp\UserBundle\Entity\UserRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use ErmineApp\ConstantsBundle\Constants\ConstantsList;

class UserManager {

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @var SessionRepository
     */
    protected $sessionRepo;

    /**
     * @var  Container
     */
    protected $container;


    public function __construct(
            UserRepository $userRepo,
            SessionRepository $sessionRepo,
            Container $container
    )
    {
        $this->userRepo = $userRepo;
        $this->sessionRepo = $sessionRepo;
        $this->container = $container;
     }

    /**
     * @param $socData
     * @param $loginData
     * @param bool|false $isPassLogin
     * @return array
     */
    public function setUserInfo($socData, $loginData, $isPassLogin = false)
    {
        $socToken = null;
        $socSecret = null;
        $user = Null;
        $restToken = Null;
        $err = '';

        if(!$socData){ /*get Exist User*/
            $existingUserArr = $this->getExistUser($loginData, $isPassLogin); /*password user*/
        }else{
            $existingUserArr = $this->getExistUserSoc($socData); /*soc user*/
        }

        if($existingUserArr['errorMessage'] != ''){ /*if error*/
            return $existingUserArr;
        }

        if(!$existingUser = $existingUserArr['existingUser']){  /* If old user dose not exist Create new user*/
            $userData = $this->newUserWithCommonInfo($socData, $loginData);
            $err = array_key_exists('errorMessage', $userData) ? $userData['errorMessage'] : '' ;
            if(array_key_exists('user', $userData)){
                $user = $userData['user'];
                $restToken = $this->setSession($user, $socToken, $socSecret);
            }

        } else{  /*User  already exist*/
            if(!$isPassLogin){ /*Registration*/
                $err = ConstantsList::REGISTER_ERROR_ACCOUNT_EXISTS ;
            }else{
                $user = $existingUser;
                $restToken = $this->setSession($user, $socToken, $socSecret);
            }
        }
        return ['errorMessage' => $err, 'user' => $user, 'restToken' => $restToken];
    }

    /**
     * @param $user
     * @param $socToken
     * @param null $socSecret
     * @return string
     */
    public function setSession($user, $socToken, $socSecret = null){

        $restToken = $this->getNewRestToken();

        $nowDate = new \DateTime('now');
        $expDate = new \DateTime('now +1 month');

        $existingSession = $this->sessionRepo->findOneByUser($user);

        /*Session for this User Doesnt exist*/

        if(!$existingSession){
            /**
             * @var Session
             */
            $session = new Session();
            $session
                ->setCreatedAt($nowDate)
                ->setExpiredAt($expDate)
                ->setSocToken($socToken)
                ->setSocSecret($socSecret)
                ->setRestToken($restToken)
                ->setUser($user)
            ;
        } else{

            /*Session for this User already exist. Update it.*/

            $existingSession
                ->setCreatedAt($nowDate)
                ->setExpiredAt($expDate)
                ->setSocToken($socToken)
                ->setSocSecret($socSecret)
                ->setRestToken($restToken)
            ;
            $session = $existingSession;
        }

        $this->sessionRepo->save($session);
        return $restToken;
    }

    /**
     * get age from unix date format
     * @param $date
     * @return bool|string
     */
    public function getAgeFromDate($date){
        $birthDate = $date;
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        $age = strlen($age) > 2 ? '' : $age;
        return $age;
    }

    /**
     * @param User $user
     * @return int|mixed
     */
    public function getRadius(User $user){
        /** @var Settings $settings */
        if(!is_object($settings = $user->getSettings()) || !$radius = $user->getSettings()->getRadius()){
            return $this->container->getParameter('default_radius');
        }

        return 1760 * $radius;
    }

    /**
     * generate RestToken
     * @return string
     */
    public function getNewRestToken(){
        $restToken = md5(uniqid(mt_rand(), true));
        return $restToken;
    }

    /**
     * @param $fbToken
     * @param $restToken
     * @param $user
     * @return bool
     */
    public function createSession( $fbToken, $restToken , $user){
        $nowDate = new \DateTime('now');
        $expDate = new \DateTime('now +1 month');

        /**
         * @var Session
         */
        $session = new Session();
        $session
            ->setCreatedAt($nowDate)
            ->setExpiredAt($expDate)
            ->setFbToken($fbToken)
            ->setRestToken($restToken)
            ->setUser($user)
        ;
        $this->sessionRepo->save($session);

        /*CHECK CHAT PASSWORD*/
        $this->jabberManager->updateOfUserPassword($user);
        return true;
    }

    /**
     * unixToAge
     * @param $unix
     * @return float|int|string
     */
    public function unixToAge($unix){
        try{
            $currTime = time();
            $age = $currTime - $unix;
            $age = $age / 60 / 60 / 24 / 365; // Convert seconds to years
            $age =   number_format($age, 3, '.', '');
            $age = explode('.', $age)[0];
            return $age;
        }catch (\Exception $e){

        }
        return 18;
    }

    /**
     * @param $loginData
     * @param $isPassLogin
     * @return array
     */
    public function getExistUser($loginData, $isPassLogin){
        $errorMessage = '';
        $existingUser = False;
        /** @var UserRepository $userRepo */
        $userRepo = $this->userRepo;
        
        $encoder = $this->container->get('security.password_encoder');
        $existingUser = $userRepo->findOneByName($loginData['name']);
        if(is_object($existingUser)) {
            if ($isPassLogin){ /*Login*/
                if (!$encoder->isPasswordValid($existingUser, $loginData['pass']/*, $user->getSalt()*/)) { /*Check Pass*/
                    $errorMessage = 'Incorrect password';
                }
            }else{ /*Registration*/
                $errorMessage = ConstantsList::REGISTER_ERROR_NAME_EXISTS;
            }            
        }else{
            /* incorrect Name */
            if ($isPassLogin){
                $errorMessage = 'Incorrect name';
            }
        }
        $res = ['existingUser' => $existingUser, 'errorMessage' => $errorMessage];

        return $res;
    }

    /**
     * @param $socData
     * @return array
     */
    public function getExistUserSoc($socData){
        $existingUser = False;
        $socId = $socData['socId'];
        $socToken = $socData['socToken'];
        $socSecret = array_key_exists('socSecret' ,$socData)? $socData['socSecret'] : null;
        $socName = $socData['socName'];

        switch ($socName) {
            case 'facebook':
                $existingUser = $this->userRepo->findOneByFbid($socId);
                break;
            case 'twitter':
                $existingUser = $this->userRepo->findOneByTwid($socId);
                break;
            case 'google':
                $existingUser = $this->userRepo->findOneByGoid($socId);
                break;
        }
//        var_dump($existingUser);die();
        return ['existingUser' => $existingUser, 'errorMessage' => ''];
    }

    /**
     * @param $socData
     * @param $loginData
     * @return User
     */
    public function newUserWithCommonInfo($socData, $loginData){
        /**@var  User  $user*/
        $user = new User();

        $encoder = $this->container->get('security.password_encoder');

        if(!$socData) {
            $nameEmailArr = ['name' => $loginData['name'], 'email' => $loginData['name'], 'errorMessage' => ''];
        }else {
            $nameEmailArr = $this->getNameEmlSoc($socData);
            if($nameEmailArr['errorMessage'] != ''){
                return $nameEmailArr;
            }

            $socName = $socData['socName'];
            $socId = $socData['socId'];

            /*Save Sco net Id*/
            if($socName == 'facebook')
                $user->setFbid($socId);
            if($socName == 'twitter')
                $user->setTwid($socId);
            if($socName == 'google')
                $user->setGoid($socId);
        }
        $user
            ->setRole('ROLE_USER')
            ->setCreated(new \DateTime('now'))
            ->setLogin('1')
            ->setStatus('1')
            ->setLanStatus('1')
            ->setIsRegister(1)
            ->setName($nameEmailArr['name'])
            ->setEmail($nameEmailArr['email'])
        ;

        /*Add Pass*/
        if(!$socData){
            $loginData['encodedPass'] =  $encoder->encodePassword($user, $loginData['pass']);
            $user
                ->setPassword($loginData['encodedPass'])
            ;
        }
        $this->userRepo->save($user);

        return ['user' => $user, 'errorMessage' => $nameEmailArr['errorMessage']];
    }

    /**
     * @param $socData
     * @return array
     */
    public function getNameEmlSoc($socData){
        $socUserName = '';
        $errorMessage = '';
        $socName = $socData['socName'];
        $socToken = $socData['socToken'];
        $socSecret = array_key_exists('socSecret', $socData) ? $socData['socSecret'] : Null;

        /** @var SocNetManager $socNetManager */
        $socNetManager = $this->container->get('ermine_appsocnets_manager');
        /** @var SocialNetAdapter $socAdapter */
        $socAdapter = $socNetManager->getAdapter($socName);
        $res = $socAdapter->checkToken(['token' => $socToken, 'secret' => $socSecret]); /* Get data from soc net */

        if($res["errorMessage"] === '' ){
            $socUserName = $res['data']['name'];
        }else{
            $errorMessage = is_array($res["errorMessage"]) ? json_encode($res["errorMessage"]) : $res["errorMessage"];
        }

        return ['name' => $socUserName, 'email' => '', 'errorMessage' => $errorMessage];
    }
}