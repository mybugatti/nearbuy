<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Tests\Fixtures\Form\CollectionType;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account", "entreprise"})
     */
    protected $id;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account", "entreprise"})
     */
    protected $username;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $email;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $enabled;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $salt;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $lastLogin;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $groups;

    /**
     * @inheritdoc
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    protected $roles;

    /**
     * @ORM\OneToMany(targetEntity="UserDescription", mappedBy="user", cascade={"persist","remove"})
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    private $descriptions;

    /**
     * @ORM\OneToMany(targetEntity="Favourite", mappedBy="user", cascade={"persist","remove"})
     */
    private $favourites;

    /**
     * @ORM\OneToOne(targetEntity="Settings", inversedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="settings_id", referencedColumnName="id")
     *
     * @JMS\Expose
     * @JMS\Groups({"user","account"})
     */
    private $settings;

    /**
     * @ORM\OneToMany(targetEntity="Employment", mappedBy="user", cascade={"persist","remove"})
     */
    private $employments;

    /**
     * @ORM\OneToMany(targetEntity="UserPromotion", mappedBy="user", cascade={"persist","remove"})
     *
     * @JMS\Expose
     * @JMS\SerializedName("relatedPromotions")
     * @JMS\Groups({"user","account"})
     */
    private $userPromotion;

    /**
     * @var boolean
     */
    private $business = false;

    public function __construct()
    {
        $this->descriptions = new ArrayCollection();
        $this->favourites = new ArrayCollection();
        $this->employments = new ArrayCollection();
        $this->userPromotion = new ArrayCollection();

        parent::__construct();
    }



    /**
     * @return int
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
     * Add favourite category
     *
     * @param Category $category
     *
     * @return User
     */
    public function addFavouriteCategory(Category $category)
    {
        $favourite = new Favourite();
        $favourite->setUser($this);
        $favourite->setCategory($category);

        $this->favourites[] = $favourite;

        return $this;
    }

    /**
     * Remove favourite category
     *
     * @param Category $category
     * @return ArrayCollection
     */
    public function removeFavouriteCategory(Category $category)
    {
        $filtredCollection = $this->favourites->filter(function($favourite)use($category){
            /** @var $favourite Favourite */
            return $favourite->getCategory() == $category ? true : false;
        });
        foreach ($filtredCollection->toArray() as $favourite){
            /** @var $favourite Favourite */
            $this->favourites->removeElement($favourite);
        }
        return $filtredCollection;
    }

    /**
     * Get favourite categories
     *
     * @return ArrayCollection
     *
     * @JMS\VirtualProperty
     * @JMS\SerializedName("favouriteCategories")
     * @JMS\Groups({"user","account"})
     */
    public function getFavouriteCategories()
    {
        $favouriteCategories = new ArrayCollection();
        foreach ($this->favourites->filter(function($favourite){
            /** @var $favourite Favourite */
            return $favourite->getCategory() != null ? true : false;
        })->toArray() as $favourite){
            /** @var $favourite Favourite */
            $favouriteCategories->add(array(
                'id' => $favourite->getCategory()->getId(),
                'name' => $favourite->getCategory()->getName(),
                'color' => $favourite->getCategory()->getColor()
            ));
        }
        return $favouriteCategories;
    }

    /**
     * Add favourite entreprise
     *
     * @param Entreprise $entreprise
     *
     * @return User
     */
    public function addFavouriteEntreprise(Entreprise $entreprise)
    {
        $favourite = new Favourite();
        $favourite->setUser($this);
        $favourite->setEntreprise($entreprise);

        $this->favourites[] = $favourite;

        return $this;
    }

    /**
     * Remove favourite entreprise
     *
     * @param Entreprise $entreprise
     * @return ArrayCollection
     */
    public function removeFavouriteEntreprise(Entreprise $entreprise)
    {
        $filtredCollection = $this->favourites->filter(function($favourite)use($entreprise){
            /** @var $favourite Favourite */
            return $favourite->getEntreprise() == $entreprise ? true : false;
        });
        foreach ($filtredCollection->toArray() as $favourite){
            /** @var $favourite Favourite */
            $this->favourites->removeElement($favourite);
        }
        return $filtredCollection;
    }

    /**
     * Get favourite entreprises
     *
     * @return ArrayCollection
     *
     * @JMS\VirtualProperty
     * @JMS\SerializedName("favouriteEntreprises")
     * @JMS\Groups({"user","account"})
     */
    public function getFavouriteEntreprises()
    {
        $favouriteEntreprises = new ArrayCollection();
        foreach ($this->favourites->filter(function($favourite){
            /** @var $favourite Favourite */
            return $favourite->getEntreprise() != null ? true : false;
        })->toArray() as $favourite){
            /** @var $favourite Favourite */
            $favouriteEntreprises->add(array(
                'id' => $favourite->getEntreprise()->getId(),
                'name' => $favourite->getEntreprise()->getName(),
                'description' => $favourite->getEntreprise()->getDescription()
            ));

        }
        return $favouriteEntreprises;
    }

    /**
     * Add description
     *
     * @param \NearBuy\DataBundle\Entity\UserDescription $description
     *
     * @return User
     */
    public function addDescription(\NearBuy\DataBundle\Entity\UserDescription $description)
    {
        $this->descriptions->add($description);

        return $this;
    }

    /**
     * Remove description
     *
     * @param \NearBuy\DataBundle\Entity\UserDescription $description
     */
    public function removeDescription(\NearBuy\DataBundle\Entity\UserDescription $description)
    {
        $this->descriptions->removeElement($description);
    }

    /**
     * Get descriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * Add employment
     *
     * @param \NearBuy\DataBundle\Entity\Employment $employment
     *
     * @return User
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
     * Get employment as ID array
     *
     * @return ArrayCollection
     *
     * @JMS\VirtualProperty
     * @JMS\SerializedName("employments")
     * @JMS\Groups({"user","account"})
     */
    public function getEmploymentsAsId(){
        $employments = new ArrayCollection();
        $this->employments->forAll(function($key, $employment)use($employments){
            /** @var $employment Employment */
            $employments->add($employment->getId());
        });
        return $employments;
    }

    /**
     * Add userPromotion
     *
     * @param \NearBuy\DataBundle\Entity\UserPromotion $userPromotion
     *
     * @return User
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
     * @return boolean
     */
    public function isBusiness()
    {
        return $this->business;
    }

    /**
     * @param boolean $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }



    /**
     * Add favourite
     *
     * @param \NearBuy\DataBundle\Entity\Favourite $favourite
     *
     * @return User
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
     * Set settings
     *
     * @param \NearBuy\DataBundle\Entity\Settings $settings
     *
     * @return User
     */
    public function setSettings(\NearBuy\DataBundle\Entity\Settings $settings = null)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \NearBuy\DataBundle\Entity\Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }
}
