<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Diffusion
 *
 * @ORM\Table(name="diffusion", indexes={@ORM\Index(name="fk_diffusion_promotion_idx", columns={"promotion_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Diffusion
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
     *
     * @JMS\Expose
     * @JMS\Groups({"diffusion", "promotion"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"diffusion", "promotion"})
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"diffusion", "promotion"})
     */
    private $endDate;

    /**
     * @var \NearBuy\DataBundle\Entity\Promotion
     *
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="diffusions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="promotion_id", referencedColumnName="id")
     * })
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity="DiffusionLocal", mappedBy="diffusion", cascade={"persist"})
     *
     * @JMS\Expose
     * @JMS\SerializedName("relatedLocals")
     * @JMS\Groups({"diffusion", "promotion"})
     */
    private $diffusionLocal;

    public function __construct()
    {
        $this->diffusionLocal = new ArrayCollection();
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
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Diffusion
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Diffusion
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set promotion
     *
     * @param \NearBuy\DataBundle\Entity\Promotion $promotion
     *
     * @return Diffusion
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
     * @JMS\Groups({"diffusion"})
     */
    public function getPromotionId(){
        if($this->getPromotion()){
            return $this->getPromotion()->getId();
        }
        return null;
    }

    /**
     * Add diffusionLocal
     *
     * @param \NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal
     *
     * @return Diffusion
     */
    public function addDiffusionLocal(\NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal)
    {
        $diffusionLocal->setDiffusion($this);
        $this->diffusionLocal[] = $diffusionLocal;

        return $this;
    }

    /**
     * Remove diffusionLocal
     *
     * @param \NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal
     */
    public function removeDiffusionLocal(\NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal)
    {
        $this->diffusionLocal->removeElement($diffusionLocal);
    }

    /**
     * Get diffusionLocal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiffusionLocal()
    {
        return $this->diffusionLocal;
    }
}
