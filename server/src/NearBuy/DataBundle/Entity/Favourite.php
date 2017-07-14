<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Favourite
 *
 * @ORM\Table(name="favourite", indexes={@ORM\Index(name="fk_preferences_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_preferences_category1_idx", columns={"category_id"}), @ORM\Index(name="fk_preferences_entreprise1_idx", columns={"entreprise_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Favourite
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
     * @var \NearBuy\DataBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="favourites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \NearBuy\DataBundle\Entity\Entreprise
     *
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="favourites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * })
     */
    private $entreprise;

    /**
     * @var \NearBuy\DataBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="favourites")
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
     * Set category
     *new ArrayCollection()
     * @param \NearBuy\DataBundle\Entity\Category $category
     *
     * @return Favourite
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
     * @JMS\VirtualProperty
     * @JMS\SerializedName("category")
     * @JMS\Groups({"entreprise","user"})
     */
    public function getCategoryId(){
        if($this->getCategory()){
            return $this->getCategory()->getId();
        }
        return null;
    }

    /**
     * Set entreprise
     *
     * @param \NearBuy\DataBundle\Entity\Entreprise $entreprise
     *
     * @return Favourite
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
     * @JMS\VirtualProperty
     * @JMS\SerializedName("entreprise")
     * @JMS\Groups({"user"})
     */
    public function getEntrepriseId(){
        if($this->getEntreprise()){
            return $this->getEntreprise()->getId();
        }
        return null;
    }

    /**
     * Set user
     *
     * @param \NearBuy\DataBundle\Entity\User $user
     *
     * @return Favourite
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
     * @JMS\Groups({"entreprise"})
     */
    public function getUserId(){
        if($this->getUser()){
            return $this->getUser()->getId();
        }
        return null;
    }

}
