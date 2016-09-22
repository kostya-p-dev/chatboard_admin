<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attachment
 */
class Attachment
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set path
     *
     * @param string $path
     * @return Attachment
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
     * Set fileName
     *
     * @param string $fileName
     * @return Attachment
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Attachment
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
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
