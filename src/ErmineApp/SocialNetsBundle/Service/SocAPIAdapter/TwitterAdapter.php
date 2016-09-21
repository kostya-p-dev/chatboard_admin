<?php

namespace ErmineApp\SocialNetsBundle\Service\SocAPIAdapter;

use Codebird\Codebird;

class TwitterAdapter implements SocialNetAdapter {

    public function send($data){}

    public function getUserInfo($data){}

    /**
     * check twitter token
     * @param $data
     * @return array
     */
    public function checkToken($data){

        Codebird::setConsumerKey(
            '52xgfZZfJTzMKZ6OXKM4Jq1uE',
            'SmWbo5Zy1mp9Ii7Kjr6DlNIwPfm4njQLoSgfwdtiFoMblyMyK3');
        $cb = Codebird::getInstance();

//        test
        $data['token'] = '3344118161-8BKcq0Qaq5zxQYYsotGp9Vz2trBx05vUgBNFmze';
        $data['secret'] = '8boU9lWuTha9GIzc82mX452UG6074bCjqnxFEyrrAR7Vu';

        $cb->setToken($data['token'], $data['secret']);

        $reply = $cb->account_verifyCredentials();
        if(property_exists($reply, 'errors')){
           $return = ['errorMessage' => $reply->errors];
        }else{
           $return = ['errorMessage' => '', 'data' => ['id' => $reply->id, 'name' => $reply->name]];
        }
        return $return;
    }
}