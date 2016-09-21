<?php

namespace ErmineApp\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Files
 */
class Files
{
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $path;

    /**
     * @var integer
     */
    private $fileorder;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $expiredAt;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ErmineApp\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set name
     *
     * @param string $name
     * @return Files
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
     * Set type
     *
     * @param string $type
     * @return Files
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
     * Set path
     *
     * @param string $path
     * @return Files
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
     * Set fileorder
     *
     * @param integer $fileorder
     * @return Files
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Files
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
     * @return Files
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
     * @return Files
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
