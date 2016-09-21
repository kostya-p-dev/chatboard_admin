<?php

namespace ErmineApp\FilesBundle\Service;

use ErmineApp\SpotsBundle\Entity\Files;
use ErmineApp\UserBundle\Entity\Session;
use ErmineApp\UserBundle\Entity\User;
use ErmineApp\FilesBundle\Service\UploadFilesStrategies\AbstractUploadStrategy;
use ErmineApp\UserBundle\Entity\UserRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FilesManager
 * @package ErmineApp\FilesBundle\Service
 */
class FilesManager {
    /**
     * @var  Container
     */
    protected $container;


    public function __construct(
            Container $container
    )
    {
        $this->container = $container;
    }

    /**
     * @param $object
     * @param $file
     * @param $oldFileEntity
     * @param bool $fileType
     * @return bool
     */
    public function uploadFile($object, $file, $oldFileEntity = false,  $fileType = false){

        if(!$originExt = $this->getFileType($file)){
            return false;
        }

        /** @var AbstractUploadStrategy  $uploader*/
        if(!$uploader = $this->getUploader($type= !$fileType ? $this->getFileType($file) : $fileType)){
            return false;
        }

        if($oldFileEntity != false){
            $uploader->setOldFileEntity($oldFileEntity);
        }

        if(!$fileEntity = $uploader->saveFile($file, $object) ){
            return false;
        }

        return $fileEntity;
    }

    /**
     * getUploader
     * @param $type
     * @return bool
     */
    protected function getUploader($type){
        $className = __NAMESPACE__. '\\UploadFilesStrategies\\' .ucwords($type)."Strategy";
        if(!class_exists($className)){
            return false;
        }
        $strategy = new $className($this->container);
        return $strategy;
    }

    /**
     * getFileType
     * @param $file
     * @return bool|\SplFileInfo
     */
    protected function getFileType($file){
        if($file->getClientOriginalName() != null){
            $info = new \SplFileInfo($file->getClientOriginalName());
            return $info->getExtension();
        }
        return false;
    }


    /**
     * @param $originalFile
     * @param $outputFile
     * @param $quality
     * @return bool
     */
    public function png2jpg($originalFile, $outputFile, $quality) {
        if(!$image = imagecreatefrompng($originalFile)){

            return false;
        }
        imagejpeg($image, $outputFile, $quality);
        imagedestroy($image);
    }

    /**
     * generate random name
     * @param int $max
     * @return string
     */
    public function getRandomName($max = 6){
        $l =  '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($l), 0, $max);
    }

    /**
     * @param $path
     * @return null|string
     */
    public function getAbsoluteUrl($path){
        if(is_string($path)){
            $url = trim($path, '/');
        }else{
            return null;
        }

        $scadDomain = $this->container->getParameter('site_domain') .'/';
        return $scadDomain.$url;
    }

    /**
     * @param $path
     * @param null $className
     * @return array|null
     */
    public function getAllImgSizeUrl($path, $className = null){
        if(is_string($path)){
            $url = trim($path, '/');
        }else{
            return null;
        }

        $urlArr = explode('/', $url);
        $fileName = end($urlArr);

        $cnt = count($urlArr);
        $tail = $urlArr[$cnt - 2]. '/' .$urlArr[$cnt - 1];

        /*Get sizes for current class*/
        if($this->container->hasParameter($className . '_sizes')){
            $sizes = $this->container->getParameter($className . '_sizes');
        }else{
            $sizes = $this->container->getParameter('default_size');
        }

        $res = [];
        foreach($sizes as $s){
            $res[$s] = str_replace($tail, $s.'/'.$fileName, $path );
        }

        return $res;
    }

    /**
     * @param $data
     * @return UploadedFile
     */
    public function getImgObjFromLink($data){
        $uploadDir = $this->container->get('kernel')->getRootDir().'/../web/upload/';
        $tmpDir = $this->container->get('kernel')->getRootDir().'/../web/upload/temp/';


        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0777);
            if(!file_exists($tmpDir)){
                mkdir($tmpDir, 0777);
            }
        }


        file_put_contents($tmpDir.$data['name'], file_get_contents($data['link']));

        $arr = explode('.', $data['name']);
        $type = end($arr);

        $uploadedFile = new UploadedFile(
            $tmpDir.$data['name'],
            $data['name'],
            $type
        );
        return $uploadedFile;
    }

    /**
     * updateUrls
     * @param $ret
     * @return array
     */
    public function updateUrls($ret, $isPromotion = "0"){
        $result = [];
        $dateCurrent = new \DateTime('now');
        $user = $this->container->get('security.context')->getToken()->getUser();
        /** @var UserRepository $userRepo */
        $userRepo = $this->container->get('app_user_repository');
        if(is_object($user)){
            $userFriendsIdsArr = $userRepo->getFriendsIdsArray($user->getId());
        }else{
            $userFriendsIdsArr = [];
        }

        foreach($ret as $row){

            /*if not promotion check expired date*/
            if($isPromotion == "0" && $row['fileorder'] == "0"){
                /*Check live period  already expired*/
                if(array_key_exists('expiredAt', $row) && !is_null($row['expiredAt'])){
                    $format = 'Y-m-d H:i:s';
                    $expiredDate = \DateTime::createFromFormat($format, $row['expiredAt']);
                    $expiredDate->modify('+12 hours');

                }else{
                    $expiredDate = $dateCurrent;
                    $expiredDate->modify('-1 hours');
                }

                /*If live period  already expired Hide Image*/
                $interval = date_diff($dateCurrent, $expiredDate);
                $hrs = (int) $interval->format('%r%H');
                if($hrs < 0){
                    continue;
                }
            }

            $filePathes = [];
            $userPathes = [];

            if(array_key_exists('spotPath', $row)){
                $absolutFilePath = $this->getAbsoluteUrl($row['spotPath']);
                $filePathes = $this->getAllImgSizeUrl($absolutFilePath, 'spots');
            }
            if(array_key_exists('userPath', $row)){
                $absolutUserPath = $this->getAbsoluteUrl($row['userPath']);
                $userPathes = $this->getAllImgSizeUrl($absolutUserPath, 'user');
            }

            $row['spotPath'] = $filePathes;
            $row['userPath'] = $userPathes;

            /*If friend set is_friend = true*/
            if(in_array($row['uId'], $userFriendsIdsArr)){
                $row['isMyFriend'] = 1;
            }else{
                $row['isMyFriend'] = 0;
            }

            if(is_null($row['love_count'])){
                $row['love_count'] = 0;
            }else{
                $row['love_count'] = intval($row['love_count']);
            }


            $result[] = $row;
        }
        return $result;
    }

    /**
     * @param Files $file
     */
    public function removeFile( $file){
        $pathParts = explode('/', trim($file->getPath(), '/'));
        $root = $this->container->get('kernel')->getRootDir();

        $truePath = $root.'/../web/'.$pathParts[0].'/'.$pathParts[1].'/'.$pathParts[2].'/'.$pathParts[3];
        $fs = new Filesystem();
        $fs->remove($truePath);
    }

    /**
     * @param Files $file
     */
    public function removeImageFile( $file){
        $pathParts = explode('/', trim($file->getPath(), '/'));
        $root = $this->container->get('kernel')->getRootDir();

        $truePath = $root.'/../web/'.$pathParts[0].'/'.$pathParts[1].'/'.$pathParts[2].'/'.$pathParts[3].'/'.$pathParts[4];
        $fs = new Filesystem();
        $fs->remove($truePath);
    }


}