<?php

namespace ErmineApp\SocialNetsBundle\Service\SocAPIAdapter;

/**
 * Class FacebookAdapter
 * @package ErmineApp\SocialNetsBundle\Service\SocAPIAdapter
 */
class FacebookAdapter implements SocialNetAdapter {

    /**
     * @param $data
     * @return mixed
     */
    public function send($data){
        return [];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getUserInfo($data){
        return [];
    }

    /**
     * check facebook token
     * @param $data
     * @return mixed
     */
    public function checkToken($data){
        $params = array('access_token' => $data['token']);
        $res = $this->url_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params)));
        return $res;
    }

    /**
     * get data by url
     * @param $Url
     * @return array
     */
    function url_get_contents ($Url) {
        if (!function_exists('curl_init')){
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get the code of request
        curl_close($ch);

        if($httpCode == 200){
            return ['errorMessage' => '', 'data' => json_decode($output, true)];
        }else{
            return ['errorMessage' => json_decode($output, true), 'data' => []];
        }
        return  ['errorMessage' => 'undefined fb SDK error', 'data' => []];
    }

}