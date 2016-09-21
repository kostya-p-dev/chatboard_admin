<?php

namespace ErmineApp\FilesBundle\Service\UploadFilesStrategies;


class JpegStrategy extends AbstractUploadStrategy{

    public function saveFile($file, $object){


        $parameters = [
            'compress' => true
        ];

        parent::setUploadDirImg($object);
        $resp = parent::saveImgCompress($file, $parameters);


        return $resp;
    }

} 