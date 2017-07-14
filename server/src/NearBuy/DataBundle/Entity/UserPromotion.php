<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * UserPromotion
 *
 * @ORM\Table(name="user_promotion", indexes={@ORM\Index(name="fk_user_promotion_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_user_promotion_promotion1_idx", columns={"promotion_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class UserPromotion
{
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMS\Expose
     * @JMS\Groups({"user","account","promotion"})
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_used", type="smallint", nullable=false, options={"default" : 0})
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account","promotion"})
     */
    private $nbUsed = 0;

    /**
     * @var \NearBuy\DataBundle\Entity\Promotion
     *
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="userPromotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="promotion_id", referencedColumnName="id")
     * })
     */
    private $promotion;

    /**
     * @var \NearBuy\DataBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userPromotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
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
     * Set nbUsed
     *
     * @param boolean $nbUsed
     *
     * @return UserPromotion
     */
    public function setNbUsed($nbUsed)
    {
        $this->nbUsed = $nbUsed;

        return $this;
    }

    /**
     * Get nbUsed
     *
     * @return boolean
     */
    public function getNbUsed()
    {
        return $this->nbUsed;
    }

    /**
     * Increment nbUsed
     *
     * @return UserPromotion
     */
    public function incrementNbUsed(){
        $this->nbUsed += 1;

        return $this;
    }

    /**
     * Set promotion
     *
     * @param \NearBuy\DataBundle\Entity\Promotion $promotion
     *
     * @return UserPromotion
     */
    public function setPromotion(\NearBuy\DataBundle\Entity\Promotion $promotion = null)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return \NearBuy\DataBundle\Entity\Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("promotion")
     * @JMS\Groups({"user","account"})
     */
    public function getPromotionId(){
        if($this->getPromotion()){
            return $this->getPromotion()->getId();
        }
        return null;
    }

    /**
     * Set user
     *
     * @param \NearBuy\DataBundle\Entity\User $user
     *
     * @return UserPromotion
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
     * @JMS\VirtualProperty
     * @JMS\SerializedName("user")
     * @JMS\Groups({"promotion"})
     */
    public function getUserId(){
        if($this->getUser()){
            return $this->getUser()->getId();
        }
        return null;
    }
}
