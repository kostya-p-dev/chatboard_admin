<?php

namespace ErmineApp\UserBundle\Controller;

use ErmineApp\UserBundle\Service\UserManager;
use ErmineApp\UserBundle\Service\RequestManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class UserRestController
 * @package ErmineApp\UserBundle\Controller
 */
class UserRestController extends Controller
{
    /**
     * @apiVersion 0.1.0
     * @api {post} /api/registers/facebooks Registration Facebook
     * @apiName RegisterFacebook
     * @apiGroup Users
     * @apiParam {string} facebookToken Facebook Token.
     * @apiParam {string} facebookId Facebook ID.
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * JSON:
     {
        "restToken": "423006c421b...",
        "user": {
            "uId": 10,
            "fbId": "149332...",
            "name": "Kostya Prosto",
            "email": ""
        },
        "errorCode": "0",
        "success": "1"
     }
     * @apiSampleRequest http://whrzat.gotests.com/
     */

    /**
     * Facebook registration/login
     * @param Request $request
     * @return array
     *
     */
    public function postRegisterFacebookAction(Request $request){

        $this->getRequestManager()->logRequest($request);

        /*if JS request method = OPTIONS*/
        if('OPTIONS' == $request->getRealMethod()){
            throw new BadRequestHttpException('Options');
        }


        $neededParams = ['request' => [], 'json' => ['facebookId', 'facebookToken']];
        $params = $this->getRequestManager()->checkRequestParameters($request , $neededParams, $json = true);
        if($params['errorMessage'] != ''){
            throw new HttpException(400, $params['errorMessage']);
        }
        /*Register with socials*/
        if(!$socData = $this->getRequestManager()->checkSocial($request)){
            throw new HttpException(400, 'Undefined required parameter - SocialId');
        }
        $res = $this->getUserManager()->setUserInfo($socData, false);
        if($res['errorMessage'] != ''){
            throw new HttpException(400, $res['errorMessage']);
        }
        return ['restToken' => $res['restToken'], 'user' => $this->getUserData($res['user']), 'errorCode' => '0', 'success' => '1'];

    }

    /**
     * @apiVersion 0.1.0
     * @api {post} /api/registers/twitters Registration Twitter
     * @apiName RegisterTwitter
     * @apiGroup Users
     * @apiParam {string} twitterToken Twitter Token.
     * @apiParam {string} twitterId Twitter ID.
     * @apiParam {string} twitterSecret Twitter Secret.
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * JSON:
        {
            "restToken": "423006c421b...",
            "user": {
                "uId": 10,
                "fbId": "149332...",
                "name": "Kostya Prosto",
                "email": ""
            },
            "errorCode": "0",
            "success": "1"
        }
     * @apiSampleRequest http://whrzat.gotests.com/
     */

    /**
     * @param Request $request
     * @return array
     */
    public function postRegisterTwitterAction(Request $request){
        $this->getRequestManager()->logRequest($request);
        $neededParams = ['request' => [], 'json' => ['twitterId', 'twitterToken', 'twitterSecret'] ];
        $params = $this->getRequestManager()->checkRequestParameters($request , $neededParams, $json = true);
        if($params['errorMessage'] != ''){
            throw new HttpException(400, $params['errorMessage']);
        }
        /*Register with socials*/
        if(!$socData = $this->getRequestManager()->checkSocial($request)){
            throw new HttpException(400, 'Undefined required parameter - SocialId');
        }
        $res = $this->getUserManager()->setUserInfo($socData, false);
        if($res['errorMessage'] != ''){
            throw new HttpException(400, $res['errorMessage']);
        }
        return ['restToken' => $res['restToken'], 'user' => $this->getUserData($res['user']), 'errorCode' => '0', 'success' => '1'];
    }


    /**
     * getUserData
     * @param $user
     * @return array
     */
    public function getUserData($user){
        return
            $userProfile = [
                'uId'          => $user->getId(),
                'fbId'         => $user->getFbid(),
                'name'         => $user->getName(),
                'email'        => $user->getEmail(),
                'age'          => $user->getAge(),
                'about'        => $user->getAbout()
            ];
    }


    /**
     * @apiVersion 0.1.0
     * @api {post} /api/registers/passes Registration password
     * @apiName RegisterPassword
     * @apiGroup Users
     * @apiParam {string} pass Password.
     * @apiParam {string} name Login.
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * JSON:
        {
            "restToken": "423006c421b...",
                "user": {
                    "uId": 10,
                    "name": "Kostya Prosto",
                    "email": ""
                },
            "errorCode": "0",
            "success": "1"
        }
     * @apiSampleRequest http://127.0.0.1:8000/api/registers/passes
     */

    /**
     * @param Request $request
     * @return array
     * @throws HttpException
     */
    public function postRegisterPassAction(Request $request){

        /** @var UserManager $userManager*/
        $userManager = $this->container->get('app_user_manager_service');

        /** @var RequestManager  $requestManager */
        $requestManager = $this->container->get('app_request_manager_service');
        $requestManager->logRequest($request);
        $neededParams = [
            'request' => ['pass', 'name'],
            'json'    => []
        ];

        $params = $requestManager->checkRequestParameters($request , $neededParams, $json = false);
        if($params['errorMessage'] != ''){
            throw new HttpException(400, $params['errorMessage']);
        }

        /*Update user information*/
        $res = $userManager->setUserInfo(false, $params['data'], $isPassLogin = false ); /*if true app wont create user if name wont by found*/
        if($res['errorMessage'] != ''){
            throw new HttpException(400, $res['errorMessage']);
        }
        return ['restToken' => $res['restToken'], 'user' => $this->getUserData($res['user']), 'error' => ['code' => '0'], 'success' => '1'];
    }

    /**
     * @apiVersion 0.1.0
     * @api {post} /api/logins/passes Login password
     * @apiName LoginPassword
     * @apiGroup Users
     * @apiParam {string} pass Password.
     * @apiParam {string} name Login.
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * JSON:
        {
            "restToken": "423006c421b...",
                "user": {
                    "uId": 10,
                    "name": "Kostya Prosto",
                    "email": ""
                },
            "errorCode": "0",
            "success": "1"
        }
     * @apiSampleRequest http://127.0.0.1:8000/api/logins/passes
     */

    /**
     * @param Request $request
     * @return array
     */
    public function postLoginPassAction(Request $request){
        
        /** @var UserManager $userManager*/
        $userManager = $this->container->get('app_user_manager_service');

        /** @var RequestManager  $requestManager */
        $requestManager = $this->container->get('app_request_manager_service');
        $requestManager->logRequest($request);
        $neededParams = [
            'request' => ['pass', 'name'],
            'json'    => []
        ];

        $params = $requestManager->checkRequestParameters($request , $neededParams, $json = false);
        if($params['errorMessage'] != ''){
            throw new HttpException(400, $params['errorMessage']);
        }

        /*Update user information*/
        $res = $userManager->setUserInfo(false, $params['data'], $isPassLogin = true ); /*if true app wont create user if name wont by found*/
        if($res['errorMessage'] != ''){
            throw new HttpException(400, $res['errorMessage']);
        }
        return ['restToken' => $res['restToken'], 'user' => $this->getUserData($res['user']), 'error' => ['code' => '0'], 'success' => '1'];
    }

    public function getMeAction(Request $request){
        return ['user' => $this->getUser()->getName()];
    }


    /**
     * get user manager
     * @return UserManager
     */
    protected function getUserManager(){
        /** @var UserManager $userManager*/
        $userManager = $this->container->get('app_user_manager_service');
        return $userManager;
    }

    /**
     * get request manager
     * @return RequestManager
     */
    protected function getRequestManager(){
        /** @var RequestManager  $requestManager */
        $requestManager = $this->container->get('app_request_manager_service');
        return $requestManager;
    }


}
