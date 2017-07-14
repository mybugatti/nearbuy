<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Reduction
 *
 * @ORM\Table(name="reduction", indexes={@ORM\Index(name="fk_reduction_currency1_idx", columns={"currency_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Reduction
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"reduction","promotion"})
     */
    private $id;

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
     * @ORM\Column(name="type", type="ReductionType", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"reduction","promotion"})
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"reduction","promotion"})
     */
    private $value;

    /**
     * @var \NearBuy\DataBundle\Entity\Currency
     *
     * @JMS\Expose
     * @JMS\Groups({"reduction","promotion"})
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="reductions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="reduction")
     */
    private $promotions;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
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
     * Set type
     *
     * @param string $type
     *
     * @return Reduction
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
     * Set value
     *
     * @param float $value
     *
     * @return Reduction
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set currency
     *
     * @param \NearBuy\DataBundle\Entity\Currency $currency
     *
     * @return Reduction
     */
    public function setCurrency(\NearBuy\DataBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \NearBuy\DataBundle\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("currency")
     * @JMS\Groups({"reduction"})
     */
    public function getCurrencyId(){
        if($this->getCurrency()){
            return $this->getCurrency()->getId();
        }
        return null;
    }

    /**
     * Add promotion
     *
     * @param \NearBuy\DataBundle\Entity\Promotion $promotion
     *
     * @return Reduction
     */
    public function addPromotion(\NearBuy\DataBundle\Entity\Promotion $promotion)
    {
        $this->promotions[] = $promotion;

        return $this;
    }

    /**
     * Remove promotion
     *
     * @param \NearBuy\DataBundle\Entity\Promotion $promotion
     */
    public function removePromotion(\NearBuy\DataBundle\Entity\Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * Get promotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}
