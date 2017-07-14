<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="fk_promotion_entreprise1_idx", columns={"entreprise_id"}), @ORM\Index(name="fk_promotion_reduction1_idx", columns={"reduction_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=20, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="limit_use", type="integer", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $limitUse;

    /**
     * @var string
     *
     * @ORM\Column(name="promotion_type", type="ValidationType", length=45, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     */
    private $promotionType;

    /**
     * @var \NearBuy\DataBundle\Entity\Entreprise
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="promotions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * })
     */
    private $entreprise;

    /**
     * @var \NearBuy\DataBundle\Entity\Reduction
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     * @ORM\ManyToOne(targetEntity="Reduction", inversedBy="promotions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reduction_id", referencedColumnName="id")
     * })
     */
    private $reduction;

    /**
     * @var \NearBuy\DataBundle\Entity\Category
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="promotions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @JMS\Expose
     * @JMS\Groups({"promotion"})
     * @ORM\OneToMany(targetEntity="Diffusion", mappedBy="promotion")
     */
    private $diffusions;

    /**
     * @ORM\OneToMany(targetEntity="UserPromotion", mappedBy="promotion")
     *
     * @JMS\Expose
     * @JMS\SerializedName("relatedUsers")
     * @JMS\Groups({"promotion"})
     */
    private $userPromotion;

    public function __construct()
    {
        $this->diffusions = new ArrayCollection();
        $this->userPromotion = new ArrayCollection();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set description
     *
     * @param string $description
     *
     * @return Promotion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Promotion
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set limitUse
     *
     * @param boolean $limitUse
     *
     * @return Promotion
     */
    public function setLimitUse($limitUse)
    {
        $this->limitUse = $limitUse;

        return $this;
    }

    /**
     * Get limitUse
     *
     * @return boolean
     */
    public function getLimitUse()
    {
        return $this->limitUse;
    }

    /**
     * Set promotionType
     *
     * @param string $promotionType
     *
     * @return Promotion
     */
    public function setPromotionType($promotionType)
    {
        $this->promotionType = $promotionType;

        return $this;
    }

    /**
     * Get promotionType
     *
     * @return string
     */
    public function getPromotionType()
    {
        return $this->promotionType;
    }

    /**
     * Set entreprise
     *
     * @param \NearBuy\DataBundle\Entity\Entreprise $entreprise
     *
     * @return Promotion
     */
    public function setEntreprise(\NearBuy\DataBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \NearBuy\DataBundle\Entity\Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set reduction
     *
     * @param \NearBuy\DataBundle\Entity\Reduction $reduction
     *
     * @return Promotion
     */
    public function setReduction(\NearBuy\DataBundle\Entity\Reduction $reduction = null)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction
     *
     * @return \NearBuy\DataBundle\Entity\Reduction
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * Set category
     *
     * @param \NearBuy\DataBundle\Entity\Category $category
     *
     * @return Promotion
     */
    public function setCategory(\NearBuy\DataBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \NearBuy\DataBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add diffusion
     *
     * @param \NearBuy\DataBundle\Entity\Diffusion $diffusion
     *
     * @return Promotion
     */
    public function addDiffusion(\NearBuy\DataBundle\Entity\Diffusion $diffusion)
    {
        $this->diffusions[] = $diffusion;

        return $this;
    }

    /**
     * Remove diffusion
     *
     * @param \NearBuy\DataBundle\Entity\Diffusion $diffusion
     */
    public function removeDiffusion(\NearBuy\DataBundle\Entity\Diffusion $diffusion)
    {
        $this->diffusions->removeElement($diffusion);
    }

    /**
     * Get diffusions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiffusions()
    {
        return $this->diffusions;
    }

    /**
     * Get diffusion as ID array
     *
     * @return ArrayCollection
     *
     * @JMS\VirtualProperty
     * @JMS\SerializedName("diffusions")
     * @JMS\Groups({"promotion"})
     */
    public function getDiffusionsAsId(){
        $diffusions = new ArrayCollection();
        $this->diffusions->forAll(function($key, $diffusion)use($diffusions){
            /** @var $diffusion Diffusion */
            $diffusions->add($diffusion->getId());
        });
        return $diffusions;
    }

    /**
     * Add userPromotion
     *
     * @param \NearBuy\DataBundle\Entity\UserPromotion $userPromotion
     *
     * @return Promotion
     */
    public function addUserPromotion(\NearBuy\DataBundle\Entity\UserPromotion $userPromotion)
    {
        $this->userPromotion[] = $userPromotion;

        return $this;
    }

    /**
     * Remove userPromotion
     *
     * @param \NearBuy\DataBundle\Entity\UserPromotion $userPromotion
     */
    public function removeUserPromotion(\NearBuy\DataBundle\Entity\UserPromotion $userPromotion)
    {
        $this->userPromotion->removeElement($userPromotion);
    }

    /**
     * Get userPromotion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserPromotion()
    {
        return $this->userPromotion;
    }

    /**
     * @return mixed
     *
     * @JMS\VirtualProperty
     * @JMS\Groups({"promotion"})
     */
    public function getNbUsed()
    {
        $nbUsed = 0;

        foreach($this->getUserPromotion() as $promotionUsage){
            $nbUsed += $promotionUsage->getNbUsed();
        }

        return $nbUsed;
    }
}
