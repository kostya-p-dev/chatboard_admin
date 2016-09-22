<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthData
 */
class AuthData
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $job;

    /**
     * @var boolean
     */
    private $pushEnable;

    /**
     * @var string
     */
    private $avatarPath;

    /**
     * @var integer
     */
    private $lastOnline;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var integer
     */
    private $sipId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set username
     *
     * @param string $username
     * @return AuthData
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
     * Set password
     *
     * @param string $password
     * @return AuthData
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set job
     *
     * @param string $job
     * @return AuthData
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set pushEnable
     *
     * @param boolean $pushEnable
     * @return AuthData
     */
    public function setPushEnable($pushEnable)
    {
        $this->pushEnable = $pushEnable;

        return $this;
    }

    /**
     * Get pushEnable
     *
     * @return boolean 
     */
    public function getPushEnable()
    {
        return $this->pushEnable;
    }

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     * @return AuthData
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatarPath = $avatarPath;

        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string 
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    /**
     * Set lastOnline
     *
     * @param integer $lastOnline
     * @return AuthData
     */
    public function setLastOnline($lastOnline)
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * Get lastOnline
     *
     * @return integer 
     */
    public function getLastOnline()
    {
        return $this->lastOnline;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return AuthData
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set sipId
     *
     * @param integer $sipId
     * @return AuthData
     */
    public function setSipId($sipId)
    {
        $this->sipId = $sipId;

        return $this;
    }

    /**
     * Get sipId
     *
     * @return integer 
     */
    public function getSipId()
    {
        return $this->sipId;
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
