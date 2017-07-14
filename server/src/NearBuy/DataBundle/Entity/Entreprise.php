<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Entreprise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise", "promotion", "local"})
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise", "promotion", "local"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=14, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise", "promotion"})
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise", "promotion"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="text", length=65535, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise", "promotion"})
     */
    private $schedule;

    /**
     * @ORM\OneToMany(targetEntity="Favourite", mappedBy="entreprise")
     *
     * @JMS\Expose
     * @JMS\SerializedName("favourites")
     * @JMS\Groups({"entreprise"})
     */
    private $favourites;

    /**
     * @ORM\OneToMany(targetEntity="Local", mappedBy="entreprise")
     */
    private $locals;

    /**
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="entreprise")
     */
    private $promotions;

    /**
     * @ORM\OneToMany(targetEntity="Employment", mappedBy="entreprise")
     */
    private $employments;

    /**
     * @ORM\OneToMany(targetEntity="EntrepriseCategory", mappedBy="entreprise", cascade={"persist"})
     *
     * @JMS\Expose
     * @JMS\SerializedName("relatedCategories")
     * @JMS\Groups({"entreprise"})
     */
    private $entrepriseCategory;

    public function __construct()
    {
        $this->favourites = new ArrayCollection();
        $this->locals = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->employments = new ArrayCollection();
        $this->entrepriseCategory = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @param string $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Entreprise
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
     * Set siret
     *
     * @param string $siret
     *
     * @return Entreprise
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



   
    /**
     * Add favourite
     *
     * @param \NearBuy\DataBundle\Entity\Favourite $favourite
     *
     * @return Entreprise
     */
    public function addFavourite(\NearBuy\DataBundle\Entity\Favourite $favourite)
    {
        $this->favourites[] = $favourite;

        return $this;
    }

    /**
     * Remove favourite
     *
     * @param \NearBuy\DataBundle\Entity\Favourite $favourite
     */
    public function removeFavourite(\NearBuy\DataBundle\Entity\Favourite $favourite)
    {
        $this->favourites->removeElement($favourite);
    }

    /**
     * Get favourites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavourites()
    {
        return $this->favourites;
    }

    /**
     * Add local
     *
     * @param \NearBuy\DataBundle\Entity\Local $local
     *
     * @return Entreprise
     */
    public function addLocal(\NearBuy\DataBundle\Entity\Local $local)
    {
        $this->locals[] = $local;

        return $this;
    }

    /**
     * Remove local
     *
     * @param \NearBuy\DataBundle\Entity\Local $local
     */
    public function removeLocal(\NearBuy\DataBundle\Entity\Local $local)
    {
        $this->locals->removeElement($local);
    }

    /**
     * Get locals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocals()
    {
        return $this->locals;
    }

    /**
     * Add promotion
     *
     * @param \NearBuy\DataBundle\Entity\Promotion $promotion
     *
     * @return Entreprise
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

    /**
     * Add employment
     *
     * @param \NearBuy\DataBundle\Entity\Employment $employment
     *
     * @return Entreprise
     */
    public function addEmployment(\NearBuy\DataBundle\Entity\Employment $employment)
    {
        $this->employments[] = $employment;

        return $this;
    }

    /**
     * Remove employment
     *
     * @param \NearBuy\DataBundle\Entity\Employment $employment
     */
    public function removeEmployment(\NearBuy\DataBundle\Entity\Employment $employment)
    {
        $this->employments->removeElement($employment);
    }

    /**
     * Get employments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployments()
    {
        return $this->employments;
    }

    /**
     * Add entrepriseCategory
     *
     * @param \NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory
     *
     * @return Entreprise
     */
    public function addEntrepriseCategory(\NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory)
    {
        $entrepriseCategory->setEntreprise($this);
        $this->entrepriseCategory[] = $entrepriseCategory;

        return $this;
    }

    /**
     * Remove entrepriseCategory
     *
     * @param \NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory
     */
    public function removeEntrepriseCategory(\NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory)
    {
        $this->entrepriseCategory->removeElement($entrepriseCategory);
    }

    /**
     * Get entrepriseCategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntrepriseCategory()
    {
        return $this->entrepriseCategory;
    }
}
