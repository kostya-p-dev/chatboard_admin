<?php

namespace ErmineApp\SocialNetsBundle\Service;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class SocNetManager
 * @package ErmineApp\SocialNetsBundle\Service
 */
class SocNetManager{

    /**
     * @var Container
     */
    protected $container;

    /**
     * SocNetManager constructor.
     * @param Container $container
     */
    public function __construct(Container $container){
        $this->container = $container;
    }

    public function test(){
        var_dump('test soc');die;
    }

    /**
     * get adapter for manage soc nets
     * @param $type
     * @return mixed
     */
    public function getAdapter($type){
        $claName = __NAMESPACE__. '\\SocAPIAdapter\\' .ucwords($type)."Adapter";
        $strategy = new $claName();
        return $strategy;
    }
}