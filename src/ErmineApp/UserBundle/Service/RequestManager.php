<?php

namespace ErmineApp\UserBundle\Service;

use ErmineApp\UserBundle\Service\FacebookManager;
use Symfony\Component\HttpFoundation\Request;

class RequestManager {

    public function logRequest($request)
    {
        $date = date("D M d, Y G:i");
        $conditionalArray = $_REQUEST;
        $terms = count($conditionalArray);
        $queryStr = '';
        foreach ($conditionalArray as $field => $value)
        {
            $terms--;
            $queryStr .= $field . ' = ' . $value."\n";
            if (!$terms)
            {
                $queryStr .= ' AND ';
            }
        }
        /*HTTP*/
        $myFile = "../app/logs/httplog.txt";

        file_put_contents($myFile, "\n\n..".$date.".............................................\n"
//            ,FILE_APPEND
        );
        foreach($_SERVER as $h=>$v)
            if(ereg('HTTP_(.+)',$h,$hp))
                file_put_contents($myFile, "$h = $v\n", FILE_APPEND);
        file_put_contents($myFile, "$queryStr", FILE_APPEND);
        file_put_contents($myFile, "\r\n", FILE_APPEND);
        file_put_contents($myFile, file_get_contents('php://input'), FILE_APPEND);



    }

    /**
     * @param Request $request
     * @param $neededParams
     * @param bool $json
     * @return array
     */
    public function checkRequestParameters(Request $request, $neededParams, $json = false){
        switch ($request->getMethod()) {
            case 'GET':
                $data = $request->query;
                break;
            case 'POST':
                $data = $request->request;
                break;
            default:
                return ['errorMessage' => 'Undefined requestMethod.', 'data' => []];
        }
        $res = [];
        /*Check request parameters*/
        foreach($neededParams['request'] as $np){
            if($data->get("$np") === NULL){
                return ['errorMessage' => 'Undefined required parameter - '.$np.'.', 'data' => []];
            }else{
                $res[$np] = $data->get("$np");
            }
        }
        /*Check JSON parameters*/
        if($json == true){
//            $data = '{"name":"bb","pass":"bb"}';
            if(($data = $request->request->get('testing_data')) == Null){
                /*IF NOt Test data*/
                $data = $request->getContent();
            }
            $jsonArray = json_decode($data, true);
            if($jsonArray  == null){
                return ['errorMessage' => 'Undefined format (JSON expected)', 'data' => []];
            }
            foreach($neededParams['json'] as $npJson){
                if(!array_key_exists($npJson, $jsonArray)){
                    return ['errorMessage' => 'Undefined required parameter - '.$npJson.'.', 'data' => []];
                }else{
                    $res[$npJson] =  $jsonArray[$npJson];
                    unset($jsonArray[$npJson]);
                }
            }
            /*Add end option parameters into res*/
            foreach($jsonArray as $key => $value){
                $res[$key] = $value;
            }
        }
        return ['errorMessage' => '', 'data' => $res];
    }

    /**
     * @param $request
     * @return array|bool
     */
    public function checkSocial($request){

        $jsonArray = json_decode($request->getContent(), true);

        if (array_key_exists('facebookId', $jsonArray)){
            return $socData = [
                'socName'  => 'facebook',
                'socId'    => $jsonArray['facebookId'],
                'socToken' => array_key_exists('facebookToken', $jsonArray) ? $jsonArray['facebookToken'] :  Null,

            ];
        }
        elseif (array_key_exists('twitterId', $jsonArray)){
            return $socData = [
                'socName' => 'twitter',
                'socId'   => $jsonArray['twitterId'],
                'socToken' => array_key_exists('twitterToken', $jsonArray) ? $jsonArray['twitterToken'] :  Null,
                'socSecret' => array_key_exists('twitterSecret', $jsonArray) ? $jsonArray['twitterSecret'] :  Null,
            ];
        }
        elseif (array_key_exists('googleId', $jsonArray)){
            return $socData = [
                'socName' => 'google',
                'socId'   => $jsonArray['googleId'],
                'socToken' => array_key_exists('googleToken', $jsonArray) ? $jsonArray['googleToken'] :  Null,
            ];
        }
        return false;
    }

    /**
     * @param $request
     * @return array|bool
     */
    public function checkPass($request){
//        $jsonArray = json_decode( $test = '{"name":"bb","pass":"bb"}', true);
        $jsonArray = json_decode($request->getContent(), true);
        if (array_key_exists('pass', $jsonArray) && array_key_exists('name', $jsonArray)){
            return $socData = [
                'pass' =>   $jsonArray['pass'] ,
                'name' =>   $jsonArray['name']
            ];
        }

        return false;
    }

    public function writeLog($text, $flag = ''){
        $date = date("D M d, Y G:i");

        $myFile = "../app/logs/httplog.txt";



        file_put_contents($myFile, "\n\n..".$date."........[STRIPE_".$flag."].....................................\n"
            ,FILE_APPEND
        );
        file_put_contents($myFile, "$text", FILE_APPEND);

        file_put_contents($myFile, "\n\n..".$date."........[END_STRIPE_".$flag."].....................................\n"
            ,FILE_APPEND
        );

    }

}
