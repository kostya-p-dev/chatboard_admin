<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppMessageActivity
 */
class AppMessageActivity
{
    /**
     * @var integer
     */
    private $lastActivity;

    /**
     * @var string
     */
    private $room;


    /**
     * Set lastActivity
     *
     * @param integer $lastActivity
     * @return AppMessageActivity
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return integer 
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * Get room
     *
     * @return string 
     */
    public function getRoom()
    {
        return $this->room;
    }
}
