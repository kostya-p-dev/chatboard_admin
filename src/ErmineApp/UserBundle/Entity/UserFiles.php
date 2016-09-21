<?php

namespace ErmineApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * UserFiles
 * @ExclusionPolicy("all")
 */
class UserFiles
{

    /**
     * @var integer
     */
    private $fileorder;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set fileorder
     *
     * @param integer $fileorder
     * @return UserFiles
     */
    public function setFileorder($fileorder)
    {
        $this->fileorder = $fileorder;

        return $this;
    }

    /**
     * Get fileorder
     *
     * @return integer 
     */
    public function getFileorder()
    {
        return $this->fileorder;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return UserFiles
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UserFiles
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
     * Set link
     *
     * @param string $link
     * @return UserFiles
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return UserFiles
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * @return UserFiles
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
}
