<?php

namespace ErmineApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 */
class Session
{

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $expiredAt;

    /**
     * @var string
     */
    private $restToken;

    /**
     * @var string
     */
    private $fbToken;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Session
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     * @return Session
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime 
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set restToken
     *
     * @param string $restToken
     * @return Session
     */
    public function setRestToken($restToken)
    {
        $this->restToken = $restToken;

        return $this;
    }

    /**
     * Get restToken
     *
     * @return string 
     */
    public function getRestToken()
    {
        return $this->restToken;
    }

    /**
     * Set fbToken
     *
     * @param string $fbToken
     * @return Session
     */
    public function setFbToken($fbToken)
    {
        $this->fbToken = $fbToken;

        return $this;
    }

    /**
     * Get fbToken
     *
     * @return string 
     */
    public function getFbToken()
    {
        return $this->fbToken;
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
     * Set user
     *
     * @param \ErmineApp\UserBundle\Entity\User $user
     * @return Session
     */
    public function setUser(\ErmineApp\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ErmineApp\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var string
     */
    private $socToken;

    /**
     * @var string
     */
    private $socSecret;


    /**
     * Set socToken
     *
     * @param string $socToken
     * @return Session
     */
    public function setSocToken($socToken)
    {
        $this->socToken = $socToken;

        return $this;
    }

    /**
     * Get socToken
     *
     * @return string 
     */
    public function getSocToken()
    {
        return $this->socToken;
    }

    /**
     * Set socSecret
     *
     * @param string $socSecret
     * @return Session
     */
    public function setSocSecret($socSecret)
    {
        $this->socSecret = $socSecret;

        return $this;
    }

    /**
     * Get socSecret
     *
     * @return string 
     */
    public function getSocSecret()
    {
        return $this->socSecret;
    }
}
