<?php

namespace ErmineApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * @ExclusionPolicy("all")
 */
class User implements UserInterface
{


    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $fbid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $age;

    /**
     * @var string
     */
    public $img;

    /**
     * @var string
     */
    public $primaryInterestsImg;

    /**
     * @var string
     */
    private $interestsStr;

    /**
     * @var string
     */
    private $about;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $access;

    /**
     * @var integer
     */
    private $login;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var boolean
     */
    private $gender;

    /**
     * @var boolean
     */
    private $lanStatus;

    /**
     * @var boolean
     */
    private $isRegister;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var boolean
     */
    private $isOnline;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sessions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userfiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userfiles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getRoles()
    {
//        return array('ROLE_ADMIN');
        return array($this->role);
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function equals(UserInterface $user)
    {
        return $user->getUsername() == $this->getUsername();
    }


    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fbid
     *
     * @param string $fbid
     * @return User
     */
    public function setFbid($fbid)
    {
        $this->fbid = $fbid;

        return $this;
    }

    /**
     * Get fbid
     *
     * @return string
     */
    public function getFbid()
    {
        return $this->fbid;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set age
     *
     * @param string $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return User
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set primaryInterestsImg
     *
     * @param string $primaryInterestsImg
     * @return User
     */
    public function setPrimaryInterestsImg($primaryInterestsImg)
    {
        $this->primaryInterestsImg = $primaryInterestsImg;

        return $this;
    }

    /**
     * Get primaryInterestsImg
     *
     * @return string
     */
    public function getPrimaryInterestsImg()
    {
        return $this->primaryInterestsImg;
    }

    /**
     * Set interestsStr
     *
     * @param string $interestsStr
     * @return User
     */
    public function setInterestsStr($interestsStr)
    {
        $this->interestsStr = $interestsStr;

        return $this;
    }

    /**
     * Get interestsStr
     *
     * @return string
     */
    public function getInterestsStr()
    {
        return $this->interestsStr;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return User
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set access
     *
     * @param integer $access
     * @return User
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return integer
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set login
     *
     * @param integer $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return integer
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set lanStatus
     *
     * @param boolean $lanStatus
     * @return User
     */
    public function setLanStatus($lanStatus)
    {
        $this->lanStatus = $lanStatus;

        return $this;
    }

    /**
     * Get lanStatus
     *
     * @return boolean
     */
    public function getLanStatus()
    {
        return $this->lanStatus;
    }

    /**
     * Set isRegister
     *
     * @param boolean $isRegister
     * @return User
     */
    public function setIsRegister($isRegister)
    {
        $this->isRegister = $isRegister;

        return $this;
    }

    /**
     * Get isRegister
     *
     * @return boolean
     */
    public function getIsRegister()
    {
        return $this->isRegister;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set isOnline
     *
     * @param boolean $isOnline
     * @return User
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * Get isOnline
     *
     * @return boolean
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * Add sessions
     *
     * @param \ErmineApp\UserBundle\Entity\Session $sessions
     * @return User
     */
    public function addSession(\ErmineApp\UserBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \ErmineApp\UserBundle\Entity\Session $sessions
     */
    public function removeSession(\ErmineApp\UserBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Add userfiles
     *
     * @param \ErmineApp\UserBundle\Entity\UserFiles $userfiles
     * @return User
     */
    public function addUserfile(\ErmineApp\UserBundle\Entity\UserFiles $userfiles)
    {
        $this->userfiles[] = $userfiles;

        return $this;
    }

    /**
     * Remove userfiles
     *
     * @param \ErmineApp\UserBundle\Entity\UserFiles $userfiles
     */
    public function removeUserfile(\ErmineApp\UserBundle\Entity\UserFiles $userfiles)
    {
        $this->userfiles->removeElement($userfiles);
    }

    /**
     * Get userfiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserfiles()
    {
        return $this->userfiles;
    }

    /*Files*/

    private $imgFile0;

    public function setImgFile0(UploadedFile $imgFile0 = null)
    {
        $this->imgFile0 = $imgFile0;
    }

    public function getImgFile0()
    {
        return $this->imgFile0;
    }

    /**
     * @var string
     */
    private $twid;

    /**
     * @var string
     */
    private $goid;


    /**
     * Set twid
     *
     * @param string $twid
     * @return User
     */
    public function setTwid($twid)
    {
        $this->twid = $twid;

        return $this;
    }

    /**
     * Get twid
     *
     * @return string
     */
    public function getTwid()
    {
        return $this->twid;
    }

    /**
     * Set goid
     *
     * @param string $goid
     * @return User
     */
    public function setGoid($goid)
    {
        $this->goid = $goid;

        return $this;
    }

    /**
     * Get goid
     *
     * @return string
     */
    public function getGoid()
    {
        return $this->goid;
    }


    /**
     * @var string
     */
    private $newPassword;


    /**
     * Set newPassword
     *
     * @param string $newPassword
     * @return User
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    /**
     * Get newPassword
     *
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }
}
