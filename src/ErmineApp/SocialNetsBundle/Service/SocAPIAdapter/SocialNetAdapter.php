<?php

namespace ErmineApp\SocialNetsBundle\Service\SocAPIAdapter;

interface SocialNetAdapter {

    /**
     * @param $data
     * @return mixed
     */
    public function send($data);

    /**
     * @param $data
     * @return mixed
     */
    public function getUserInfo($data);

    /**
     * @param $data
     * @return mixed
     */
    public function checkToken($data);

}