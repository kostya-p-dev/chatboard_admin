<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Credentials
 */
class Credentials
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $lastUsed;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set username
     *
     * @param string $username
     * @return Credentials
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Credentials
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set lastUsed
     *
     * @param \DateTime $lastUsed
     * @return Credentials
     */
    public function setLastUsed($lastUsed)
    {
        $this->lastUsed = $lastUsed;

        return $this;
    }

    /**
     * Get lastUsed
     *
     * @return \DateTime 
     */
    public function getLastUsed()
    {
        return $this->lastUsed;
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
}
