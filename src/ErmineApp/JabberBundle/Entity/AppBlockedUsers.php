<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBlockedUsers
 */
class AppBlockedUsers
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\JabberBundle\Entity\AuthData
     */
    private $blockedUser;

    /**
     * @var \ErmineApp\JabberBundle\Entity\AuthData
     */
    private $user;


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
     * Set blockedUser
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $blockedUser
     * @return AppBlockedUsers
     */
    public function setBlockedUser(\ErmineApp\JabberBundle\Entity\AuthData $blockedUser = null)
    {
        $this->blockedUser = $blockedUser;

        return $this;
    }

    /**
     * Get blockedUser
     *
     * @return \ErmineApp\JabberBundle\Entity\AuthData 
     */
    public function getBlockedUser()
    {
        return $this->blockedUser;
    }

    /**
     * Set user
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $user
     * @return AppBlockedUsers
     */
    public function setUser(\ErmineApp\JabberBundle\Entity\AuthData $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ErmineApp\JabberBundle\Entity\AuthData 
     */
    public function getUser()
    {
        return $this->user;
    }
}
