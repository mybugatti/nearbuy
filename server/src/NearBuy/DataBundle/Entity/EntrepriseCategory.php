<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * EntrepriseCategory
 *
 * @ORM\Table(name="entreprise_category", indexes={@ORM\Index(name="fk_entreprise_category_entreprise1_idx", columns={"entreprise_id"}), @ORM\Index(name="fk_entreprise_category_category1_idx", columns={"category_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class EntrepriseCategory
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
     * @JMS\Groups({"entreprise","category"})
     */
    private $id;

    /**
     * @var \NearBuy\DataBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="entrepriseCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \NearBuy\DataBundle\Entity\Entreprise
     *
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="entrepriseCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * })
     */
    private $entreprise;



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
     *
     * @param \NearBuy\DataBundle\Entity\Category $category
     *
     * @return EntrepriseCategory
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
     * @JMS\Groups({"entreprise"})
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
     * @return EntrepriseCategory
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
     * @JMS\Groups({"category"})
     */
    public function getEntrepriseId(){
        if($this->getEntreprise()){
            return $this->getEntreprise()->getId();
        }
        return null;
    }
}
