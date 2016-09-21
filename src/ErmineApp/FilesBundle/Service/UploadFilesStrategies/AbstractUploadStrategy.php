<?php

namespace ErmineApp\FilesBundle\Service\UploadFilesStrategies;

use ErmineApp\SpotsBundle\Entity\Files;
use ErmineApp\UserBundle\Entity\UserFiles;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractUploadStrategy {

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $uploadDir;

    /**
     * @var object UserFilesRepository
     */
    protected $userFilesRepo;

    /**
     * @var Files
     */
    protected $filesRepo;

    /**
     * @var UserFiles
     */
    protected $oldFileEntity;

    /** @var  string */
    protected $className;

    /**
     * @param Container $container
     */
    function __construct(Container $container){
        $this->container = $container;
        $this->userFilesRepo = $container->get('app_user_files_repository');
        $this->filesRepo = $container->get('app_files_repository');
        $this->oldFileEntity = false;
    }

    abstract function saveFile($file, $object);

    public function saveImgCompress(UploadedFile $uploadedFile, $parameters){

        /*get compress sizes from config by className*/
        if($this->container->hasParameter($this->className . '_sizes')){
            $sizes = $this->container->getParameter($this->className . '_sizes');
        }else{
            $sizes = $this->container->getParameter('default_size');
        }

        /*Get test filter to check images if it to small - increase it*/
        if($this->container->hasParameter($this->className . '_test_filter')){
            $test_sizes = $this->container->getParameter($this->className . '_test_filter');
        }else{
            $test_sizes = $this->container->getParameter('default_test_filter');
        }


        /*SET the largest size into end of array*/
        $parameters['size'] = $sizes;
        /** @var Filesystem $fs */
        $fs = new Filesystem();
        $rootDir = $this->container->get('kernel')->getRootDir().'/../web';

        if(is_object($uploadedFile)){
            $name = $this->getRandomName().'.'.$uploadedFile->getClientOriginalExtension();
            $userFile = $this->getImgEntity();

            /*Save largest One image*/
            $folderPath = $this->uploadDir.'/'.$userFile->getId().'/';

//            var_dump('tut');die;
            $fs->mkdir($rootDir.$folderPath.end($parameters['size']).'/', 0777);

            $this->delTree($rootDir.$folderPath.end($parameters['size']));

            copy($uploadedFile->getPathname(), $rootDir.$folderPath.end($parameters['size']).'/'.$name);



            unlink($uploadedFile->getPathname());
            $name = '/'.$name;

            /*Save others sizes from parameters*/
            if(array_key_exists('compress', $parameters) && $parameters['compress'] == true ){


                /*if picture to small - increase it*/

                $lastSizxe = end($parameters['size']);
                $fs->mkdir($rootDir.$folderPath.$lastSizxe, 0755);
                if($lastSizxe != end($parameters['size'])){
                    $this->delTree($rootDir.$folderPath.$lastSizxe);
                }
                $this->writeThumbnail($rootDir.$folderPath.$lastSizxe.$name, $folderPath.end($parameters['size']).$name,  $test_sizes);


                /*compress and crope all sizes*/

                foreach($parameters['size'] as $size){
                    $fs->mkdir($rootDir.$folderPath.$size, 0755);
                    if($size != end($parameters['size'])){
                        $this->delTree($rootDir.$folderPath.$size);
                    }
                    $this->writeThumbnail($rootDir.$folderPath.$size.$name, $folderPath.end($parameters['size']).$name,  'filter_'.$size);
                }
            }

            /*Save path into fileEntity*/
            $userFile
                ->setPath($folderPath.end($parameters['size']).$name)
            ;
            $filesRepo = $this->getRepo();
            $filesRepo->save($userFile);

        }
        return $userFile;
    }

    /**
     * getRandomNamegetRandomName
     * @param int $max
     * @return string
     */
    public function getRandomName($max = 6){
        $l =  '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($l), 0, $max);
    }

    /**
     * getUploadDir
     * @param $object
     * @return string
     */
    public function setUploadDirImg($object){
        /*get path */
        $dirArr = explode('\\', strtolower(get_class($object)));
        $className = end($dirArr);
        $relDir = '/upload/img/'.$className.'/'.$object->getId();

        $this->uploadDir = $relDir;
        $this->className = $className;

        return $relDir;
    }

    /**
     * @return UserFiles
     */
    protected function getImgEntity(){

        if($this->className == 'user'){
            if(!$userFile = $this->oldFileEntity){
                $userFile = new UserFiles();
            }
            $filesRepo = $this->userFilesRepo;
        }else{
            if(!$userFile = $this->oldFileEntity){
                $userFile = new Files();
            }
            $filesRepo = $this->filesRepo;
        }

        $userFile
            ->setName('')
            ->setPath('')
            ->setFileorder(1)
        ;
        $filesRepo->save($userFile);
        return $userFile;
    }

    /**
     * @param $imgPath
     * @param $relFile
     * @param $filter
     */
    public function writeThumbnail($imgPath, $relFile, $filter) {

        $container = $this->container;                                  // the DI container
        $dataManager = $container->get('liip_imagine.data.manager');    // the data manager service
        $filterManager = $container->get('liip_imagine.filter.manager');// the filter manager service
        $image = $dataManager->find($filter, $relFile);                 // find the image and determine its type
        $response = $filterManager->applyFilter($image, $filter);
        $thumb = $response->getContent();                               // get the image from the response

        $f = fopen($imgPath, 'w');                                      // create thumbnail file
        fwrite($f, $thumb);                                             // write the thumbnail
        fclose($f);                                                     // close the file
    }

    /**
     * @param $oldFile
     */
    public function setOldFileEntity($oldFile){
        $this->oldFileEntity = $oldFile;
    }

    /**
     * del directories tree
     * @param $dir
     * @return bool
     */
    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
//        return rmdir($dir);
        return true;
    }

    /**
     * getRepo
     * @return Files|object
     */
    public function getRepo(){
        if($this->className == 'user'){
            $repo = $this->userFilesRepo;
        }else{
            $repo = $this->filesRepo;
        }
        return $repo;
    }
}