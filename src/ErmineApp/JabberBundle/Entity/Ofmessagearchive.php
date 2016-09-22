<?php

namespace ErmineApp\JabberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmessagearchive
 */
class Ofmessagearchive
{
    /**
     * @var integer
     */
    private $conversationid;

    /**
     * @var string
     */
    private $fromjid;

    /**
     * @var string
     */
    private $fromjidresource;

    /**
     * @var string
     */
    private $tojid;

    /**
     * @var string
     */
    private $tojidresource;

    /**
     * @var integer
     */
    private $sentdate;

    /**
     * @var string
     */
    private $body;

    /**
     * @var boolean
     */
    private $isread;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set conversationid
     *
     * @param integer $conversationid
     * @return Ofmessagearchive
     */
    public function setConversationid($conversationid)
    {
        $this->conversationid = $conversationid;

        return $this;
    }

    /**
     * Get conversationid
     *
     * @return integer 
     */
    public function getConversationid()
    {
        return $this->conversationid;
    }

    /**
     * Set fromjid
     *
     * @param string $fromjid
     * @return Ofmessagearchive
     */
    public function setFromjid($fromjid)
    {
        $this->fromjid = $fromjid;

        return $this;
    }

    /**
     * Get fromjid
     *
     * @return string 
     */
    public function getFromjid()
    {
        return $this->fromjid;
    }

    /**
     * Set fromjidresource
     *
     * @param string $fromjidresource
     * @return Ofmessagearchive
     */
    public function setFromjidresource($fromjidresource)
    {
        $this->fromjidresource = $fromjidresource;

        return $this;
    }

    /**
     * Get fromjidresource
     *
     * @return string 
     */
    public function getFromjidresource()
    {
        return $this->fromjidresource;
    }

    /**
     * Set tojid
     *
     * @param string $tojid
     * @return Ofmessagearchive
     */
    public function setTojid($tojid)
    {
        $this->tojid = $tojid;

        return $this;
    }

    /**
     * Get tojid
     *
     * @return string 
     */
    public function getTojid()
    {
        return $this->tojid;
    }

    /**
     * Set tojidresource
     *
     * @param string $tojidresource
     * @return Ofmessagearchive
     */
    public function setTojidresource($tojidresource)
    {
        $this->tojidresource = $tojidresource;

        return $this;
    }

    /**
     * Get tojidresource
     *
     * @return string 
     */
    public function getTojidresource()
    {
        return $this->tojidresource;
    }

    /**
     * Set sentdate
     *
     * @param integer $sentdate
     * @return Ofmessagearchive
     */
    public function setSentdate($sentdate)
    {
        $this->sentdate = $sentdate;

        return $this;
    }

    /**
     * Get sentdate
     *
     * @return integer 
     */
    public function getSentdate()
    {
        return $this->sentdate;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Ofmessagearchive
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set isread
     *
     * @param boolean $isread
     * @return Ofmessagearchive
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;

        return $this;
    }

    /**
     * Get isread
     *
     * @return boolean 
     */
    public function getIsread()
    {
        return $this->isread;
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
