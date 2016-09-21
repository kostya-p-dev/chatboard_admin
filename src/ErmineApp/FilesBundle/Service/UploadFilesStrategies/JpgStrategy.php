<?php

namespace ErmineApp\FilesBundle\Service\UploadFilesStrategies;


class JpgStrategy extends AbstractUploadStrategy{

    public function saveFile($file, $object){


        $parameters = [
            'compress' => true
        ];

        parent::setUploadDirImg($object);
        return parent::saveImgCompress($file, $parameters);
    }

} 