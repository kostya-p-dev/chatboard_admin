<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 */
class Chat
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $jid;

    /**
     * @var boolean
     */
    private $isPublic;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $avtor;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     * @return Chat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set jid
     *
     * @param string $jid
     * @return Chat
     */
    public function setJid($jid)
    {
        $this->jid = $jid;

        return $this;
    }

    /**
     * Get jid
     *
     * @return string 
     */
    public function getJid()
    {
        return $this->jid;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Chat
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Chat
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avtor
     *
     * @param string $avtor
     * @return Chat
     */
    public function setAvtor($avtor)
    {
        $this->avtor = $avtor;

        return $this;
    }

    /**
     * Get avtor
     *
     * @return string 
     */
    public function getAvtor()
    {
        return $this->avtor;
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
