<?php

//namespace ErmineApp\SocialNetsBundle\Service;
//
//use App\InterestsBundle\Entity\Activities;
//use App\UserBundle\Entity\SessionRepository;
//use Facebook\FacebookSession;
//use Facebook\FacebookRequest;
//use Facebook\FacebookRequestException;
//use Facebook\FacebookAuthorizationException;
//use Facebook\GraphUser;
//use Symfony\Component\DependencyInjection\Container;
//
//
//class FacebookManager {
//
//
//    /**
//     * @var Container
//     */
//    protected $container;
//    /**
//     * @var SessionRepository
//     */
//    protected $sessionRepo;
//
//    public function __construct(Container $container, SessionRepository $sessionRepo)
//    {
//        $this->container = $container;
//        $this->sessionRepo = $sessionRepo;
//    }
//
//
//    /**
//     * Check FaceBook Token
//     * @param $token
//     * @return bool
//     */
//    public function checkFbToken($token)
//    {
//
//        $params = array('access_token' => $token);
//
//        $res = $this->url_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params)));
//
//        return $res;
//    }
//
//    function url_get_contents ($Url) {
//        if (!function_exists('curl_init')){
//            die('CURL is not installed!');
//        }
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $Url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $output = curl_exec($ch);
//        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get the code of request
//        curl_close($ch);
//
////        TEST
////        return
////            [
////                'id' => '100000317390816',
////                'name' => 'Vasiliy',
////                'first_name' => 'Vasiliy',
////                'last_name' => 'Pupkin',
////                'birthday' => '07/03/1988',
////                'hometown' => [
////                    'id' => '110228142339670',
////                    'name' => 'Chisinau, Moldova'
////                ],
////                'email' => 'vasiliy.pupkin@gmail.com'
////            ];
//
//
//
//        if($httpCode == 200){
//            //is ok?
//            return json_decode($output, true);
//        }/*else{
//
//            return json_decode($output, true);
//        }*/
//        return false;
//    }
//
//    /**
//     * facebookPost
//     * @param $user
//     * @param Activities $activities
//     * @param $primaryImagePath
//     * @throws \Facebook\FacebookSDKException
//     */
//    public function facebookPost($user, Activities $activities, $primaryImagePath)
//    {
//        $sessionRepo = $this->sessionRepo;
//        $token = $sessionRepo->findOneBy(['user' => $user])->getFbToken();
//        if(!$token) return;
//
//        $session = new FacebookSession($token);
//
//        if($session) {
//            try {
//                $response = (new FacebookRequest(
//                    $session, 'POST', '/me/feed', array(
//                        'link' => 'http://google.com',
//                        'message' => $activities->getTitle(),
//                        "picture" => $this->container->getParameter('site_domain').$primaryImagePath,
//                        "description" => $activities->getDescription()
//                    )
//                ))->execute()->getGraphObject();
//
//            } catch(FacebookRequestException $e) {
//
//            }
//        }
//    }
//
//    /**
//     * facebookChatPost
//     * @param $user
//     * @param $text
//     * @param $title
//     * @throws \Facebook\FacebookSDKException
//     */
//    public function facebookChatPost($user, $text, $title)
//    {
//        $sessionRepo = $this->sessionRepo;
//        $token = $sessionRepo->findOneBy(['user' => $user])->getFbToken();
//        if(!$token) return;
//
//        $session = new FacebookSession($token);
//
//        if($session) {
//            try {
//                $response = (new FacebookRequest(
//                    $session, 'POST', '/me/feed', array(
//                        'link' => 'http://google.com',
//                        'message' => $title,
//                        "picture" => $this->container->getParameter('site_domain').'/bundles/appuser/images/logo_small.png',
//                        "description" => $text
//                    )
//                ))->execute()->getGraphObject();
//
//            } catch(FacebookRequestException $e) {
//
//            }
//        }
//    }
//
//    /**
//     * getFacebookInterests
//     * @param $user
//     * @return mixed
//     */
//    public function getFacebookInterests($user)
//    {
//        $sessionRepo = $this->sessionRepo;
//        $token = $sessionRepo->findOneBy(['user' => $user])->getFbToken();
//        if(!$token) return;
//
//        $session = new FacebookSession($token);
//
//        if($session) {
//            try {
//                $response = (new FacebookRequest(
//                    $session, 'GET', '/me/likes'
//                ))->execute()
//                ->getRawResponse()
//                ;
//                $arrRes = json_decode($response, true);
//                return $arrRes['data'];
//            } catch(FacebookRequestException $e) {
//            }
//        }
//    }
//
//    /**
//     * getFacebookAccounts
//     * @param $user
//     * @return mixed
//     */
//    public function getFacebookAccounts($user)
//    {
//        $sessionRepo = $this->sessionRepo;
//        $token = $sessionRepo->findOneBy(['user' => $user])->getFbToken();
//        if(!$token) return;
//
//        $session = new FacebookSession($token);
//
//        if($session) {
//            try {
//                $response = (new FacebookRequest(
//                    $session, 'GET', '/me/accounts'
//                ))->execute()
//                ->getRawResponse()
//                ;
//
//                $arrRes = json_decode($response, true);
//
//                return $arrRes['data'];
//            } catch(FacebookRequestException $e) {
//            }
//        }
//    }
//
//    /**
//     * getInterestsUrlAndroid
//     * @param $Url
//     * @return bool
//     */
//    function getInterestsUrlAndroid ($Url) {
////        var_dump($Url);
//        if (!function_exists('curl_init')){
//            die('CURL is not installed!');
//        }
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $Url.'&redirect=false');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $output = curl_exec($ch);
//        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get the code of request
//        curl_close($ch);
//
//        if($httpCode == 200){
//            $output = json_decode($output, true);
//            if(array_key_exists('data', $output)){
//                if(array_key_exists('url', $output['data'])){
//                    return $output['data']['url'];
//                }
//            }
//        }
//        return false;
//    }
//
//}