<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * UserDescription
 *
 * @ORM\Table(name="user_description")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class UserDescription
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    private $gender;

    /**
     * @var \NearBuy\DataBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="descriptions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=45, nullable=true)
     */
    private $city;



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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return UserDescription
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return UserDescription
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return UserDescription
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return UserDescription
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
