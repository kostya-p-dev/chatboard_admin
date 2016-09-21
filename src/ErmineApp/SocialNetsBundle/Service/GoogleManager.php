<?php
//
//namespace App\UserBundle\Service;
//
//use Symfony\Component\DependencyInjection\Container;
//
//class GoogleManager {
//    /**
//     * @var Container
//     */
//    protected $container;
//
//    /**
//     * @param Container $container
//     */
//    public function __construct(Container $container){
//        $this->container = $container;
//    }
//
//    /**
//     * getYouTubeUserVideos
//     * @param $accessToken
//     * @param int $maxResult
//     * @return array
//     */
//    public function getYouTubeUserVideos($accessToken, $maxResult = 10){
//
//        $res = [];
//        try {
//            $params = array(
//                'access_token' => $accessToken,
//                'part'         => 'contentDetails',
//                'mine'         => 'true',
//            );
//            $url = 'https://www.googleapis.com/youtube/v3/channels';
//            $url .= '?' . http_build_query($params);
//            $curl = curl_init();
//
//            curl_setopt($curl, CURLOPT_URL, $url);
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
//            $result = curl_exec($curl);
//            curl_close($curl);
//
//            /*User channels*/
//            $channelsResponse = json_decode($result, true);
//
//            if(is_array($channelsResponse) && isset($channelsResponse['items']) && is_array($channelsResponse['items'])){
//                foreach ($channelsResponse['items'] as $channel) {
//                    $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
//                    $params = array(
//                        'part' => 'snippet',
//                        'access_token' => $accessToken,
//                        'playlistId'   => $uploadsListId,
//                        'maxResults' => $maxResult
//                    );
//                    $url = 'https://www.googleapis.com/youtube/v3/playlistItems';
//                    $url .= '?' . http_build_query($params);
//                    $curl = curl_init();
//
//                    curl_setopt($curl, CURLOPT_URL, $url);
//                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//                    curl_setopt($curl, CURLOPT_TIMEOUT, 5);
//                    $result = curl_exec($curl);
//                    curl_close($curl);
//
//                    /*User videos*/
//                    $playlistItemsResponse = json_decode($result, true);
//                    if(is_array($playlistItemsResponse) && isset($playlistItemsResponse['items']) && is_array($playlistItemsResponse['items'])){
//                        foreach ($playlistItemsResponse['items'] as $playlistItem) {
//                            $id = $playlistItem['snippet']['resourceId']['videoId'];
//                            $link = 'https://www.youtube.com/watch?v='. $id;
//                            $title = $playlistItem['snippet']['title'];
//                            $img = $playlistItem['snippet']['thumbnails']['default']['url'];
//
//                            $res[] = [
//                                'id'     => $id,
//                                'link'   => $link,
//                                'title'  => $title,
//                                'img'    => $img
//                            ];
//                        }
//                    }
//                }
//            }
//
//        } catch (\Exception $e) {
//
//        }
//        return count($res) > 0 ? $res : null;
//    }
//
//    /**
//     * getTimeZone
//     * @param $foo
//     * @param $lat
//     * @param $lng
//     * @return string
//     */
//    public function getTimeZone($foo, $lat, $lng){
//        $res = false;
//        $params = array(
//            'key'       => $serverApiKey = $this->container->getParameter('sacd_googleServerApiKey'),
//            'timestamp' => time(),
//            'location'  => $lat.', '.$lng,
//        );
//
//        $url = 'https://maps.googleapis.com/maps/api/timezone/json';
//        $url .= '?' . http_build_query($params);
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
//        $result = curl_exec($curl);
//        curl_close($curl);
//
//        /*User channels*/
//        $response = json_decode($result, true);
////        echo'<pre>';
////var_dump($response);
//        if(is_array($response) && isset($response['timeZoneId'])){
//            $timeZoneId = $response['timeZoneId'];
//            $timeZonesArr = $this->getTimezoneArray();
////var_dump($timeZonesArr);
//            if(array_key_exists($timeZoneId, $timeZonesArr)){
//                $hourDeltaStr = $timeZonesArr[$timeZoneId];
//
//                    $res = [
//                        'id'     => $timeZoneId,
//                        'hour'   => $hourDeltaStr[1],
//                        'minute' => ''
//                    ];
//
//            }
//        }
//        return $res;
//    }
//
//    public function getTimezoneArray(){
//        try{
//            if(!$csvfile = fopen('zones.csv','rb')){
//                return [];
//            }
//            while(!feof($csvfile)) {
//                $row = fgetcsv($csvfile);
//                $csvarray[$row[0]] = $row;
//            }
//            return $csvarray;
//        }catch (\Exception $e)
//        {}
//
//        return [];
//    }
//}