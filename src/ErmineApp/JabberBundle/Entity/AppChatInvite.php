<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppChatInvite
 */
class AppChatInvite
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\JabberBundle\Entity\Chat
     */
    private $chat;

    /**
     * @var \ErmineApp\JabberBundle\Entity\AuthData
     */
    private $authData;


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
     * Set chat
     *
     * @param \ErmineApp\JabberBundle\Entity\Chat $chat
     * @return AppChatInvite
     */
    public function setChat(\ErmineApp\JabberBundle\Entity\Chat $chat = null)
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * Get chat
     *
     * @return \ErmineApp\JabberBundle\Entity\Chat 
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * Set authData
     *
     * @param \ErmineApp\JabberBundle\Entity\AuthData $authData
     * @return AppChatInvite
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
