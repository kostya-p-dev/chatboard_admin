<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppDeviceId
 */
class AppDeviceId
{
    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\JabberBundle\Entity\AuthData
     */
    private $authData;


    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return AppDeviceId
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set authData
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $authData
     * @return AppDeviceId
     */
    public function setAuthData(\ErmineApp\JabberBundle\Entity\AuthData $authData = null)
    {
        $this->authData = $authData;

        return $this;
    }

    /**
     * Get authData
     *
     * @return \ErmineApp\JabberBundle\Entity\AuthData 
     */
    public function getAuthData()
    {
        return $this->authData;
    }
}
