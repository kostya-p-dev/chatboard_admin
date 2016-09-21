<?php
//
//namespace App\UserBundle\Service;
//
//use Symfony\Component\DependencyInjection\Container;
//use Codebird\Codebird;
//
//class TwitterService {
//    /**
//     * @var Container
//     */
//    protected $container;
//
//    /**
//     * construct
//     */
//    public function __construct(Container $container)
//    {
//        $this->container = $container;
//    }
//
//    public function tweetPost($user ,$activities, $imagePath, $token)
//    {
//
////        var_dump($this->container->get('request')->getHost().$imagePath);die;
//        $tweetText = $user->getName()." added a new activity - ".$activities->getTitle().". "
//            .$activities->getDescription().".";
//
//        $params = array(
//            'status' => $tweetText,
//           // 'media[]' => 'http://scad.gotests.com/upload/interests/150/img/268_268/interestsImg.jpeg'
//            'media[]' => 'http://scad.gotests.com'.$imagePath
//        );
//
//        Codebird::setConsumerKey(
//            'Q42j18ZXFm0QgsXfGGmqpdwbU',
//            'FS5TvqazLYLnCKkk9NcFAJKTk80KO3QqedJTnmt4Xf4JL83yxS');
//        $cb = Codebird::getInstance();
//
//        $cb->setToken($token['token'], $token['sicret']);
//
//        $reply = $cb->statuses_updateWithMedia($params);
////
////echo'<pre>';
////var_dump($reply);
//
//        return $reply;
//    }
//}
