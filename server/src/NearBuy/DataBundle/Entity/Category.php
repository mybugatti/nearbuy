<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Category
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
     * @JMS\Groups({"category", "promotion"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"category", "promotion"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"category", "promotion"})
     */
    private $color;
    /**
     * @ORM\OneToMany(targetEntity="Favourite", mappedBy="category")
     */
    private $favourites;

    /**
     * @ORM\OneToMany(targetEntity="EntrepriseCategory", mappedBy="category")
     */
    private $entrepriseCategory;

    public function __construct()
    {
        $this->favourites = new ArrayCollection();
        $this->entrepriseCategory = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Add favourite
     *
     * @param \NearBuy\DataBundle\Entity\Favourite $favourite
     *
     * @return Category
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
     * Add entrepriseCategory
     *
     * @param \NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory
     *
     * @return Category
     */
    public function addEntrepriseCategory(\NearBuy\DataBundle\Entity\EntrepriseCategory $entrepriseCategory)
    {
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

    /**
     * @return array
     */
    public function toArray(){
        return array(
            "id"=>$this->id,
            "color"=>$this->color,
            "name"=>$this->name
        );
    }

}
