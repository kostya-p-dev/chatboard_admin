<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppUserInvite
 */
class AppUserInvite
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\JabberBundle\Entity\AuthData
     */
    private $inviteUser;

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
     * Set inviteUser
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $inviteUser
     * @return AppUserInvite
     */
    public function setInviteUser(\ErmineApp\JabberBundle\Entity\AuthData $inviteUser = null)
    {
        $this->inviteUser = $inviteUser;

        return $this;
    }

    /**
     * Get inviteUser
     *
     * @return \ErmineApp\JabberBundle\Entity\AuthData 
     */
    public function getInviteUser()
    {
        return $this->inviteUser;
    }

    /**
     * Set user
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $user
     * @return AppUserInvite
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
