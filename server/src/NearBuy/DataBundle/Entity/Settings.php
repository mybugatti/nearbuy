<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Settings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notifications", type="boolean", nullable=false, options={"default" : false})
     *
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $notifications;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mails", type="boolean", nullable=false, options={"default" : false})
     *
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $mails;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="settings")
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
     * Set user
     *
     * @param \NearBuy\DataBundle\Entity\User $user
     *
     * @return Settings
     */
    public function setUser(\NearBuy\DataBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NearBuy\DataBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set notifications
     *
     * @param boolean $notifications
     *
     * @return Settings
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * Get notifications
     *
     * @return boolean
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Toggle notifications
     *
     * @return Settings
     */
    public function toggleNotifications()
    {
        $this->notifications = !$this->notifications;
        return $this;
    }

    /**
     * Set mails
     *
     * @param boolean $mails
     *
     * @return Settings
     */
    public function setMails($mails)
    {
        $this->mails = $mails;

        return $this;
    }

    /**
     * Get mails
     *
     * @return boolean
     */
    public function getMails()
    {
        return $this->mails;
    }

    /**
     * Toggle mails
     *
     * @return Settings
     */
    public function toggleMails()
    {
        $this->mails = !$this->mails;
        return $this;
    }
}
