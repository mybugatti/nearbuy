<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * DiffusionLocal
 *
 * @ORM\Table(name="diffusion_local", indexes={@ORM\Index(name="fk_diffusion_local_local1_idx", columns={"local_id"}), @ORM\Index(name="fk_diffusion_local_diffusion1_idx", columns={"diffusion_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class DiffusionLocal
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
     * @JMS\Groups({"diffusion","local", "promotion"})
     */
    private $id;

    /**
     * @var \NearBuy\DataBundle\Entity\Diffusion
     *
     * @ORM\ManyToOne(targetEntity="Diffusion", inversedBy="diffusionLocal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="diffusion_id", referencedColumnName="id")
     * })
     */
    private $diffusion;

    /**
     * @var \NearBuy\DataBundle\Entity\Local
     *
     * @JMS\Expose
     * @JMS\Groups({"diffusion","local", "promotion"})
     *
     * @ORM\ManyToOne(targetEntity="Local", inversedBy="diffusionLocal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="local_id", referencedColumnName="id")
     * })
     */
    private $local;



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
     * Set diffusion
     *
     * @param \NearBuy\DataBundle\Entity\Diffusion $diffusion
     *
     * @return DiffusionLocal
     */
    public function setDiffusion(\NearBuy\DataBundle\Entity\Diffusion $diffusion = null)
    {
        $this->diffusion = $diffusion;

        return $this;
    }

    /**
     * Get diffusion
     *
     * @return \NearBuy\DataBundle\Entity\Diffusion
     */
    public function getDiffusion()
    {
        return $this->diffusion;
    }
    
    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("diffusion")
     * @JMS\Groups({"local"})
     */
    public function getDiffusionId(){
        if($this->getDiffusion()){
            return $this->getDiffusion()->getId();
        }
        return null;
    }

    /**
     * Set local
     *
     * @param \NearBuy\DataBundle\Entity\Local $local
     *
     * @return DiffusionLocal
     */
    public function setLocal(\NearBuy\DataBundle\Entity\Local $local = null)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return \NearBuy\DataBundle\Entity\Local
     */
    public function getLocal()
    {
        return $this->local;
    }
    
    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("local")
     * @JMS\Groups({"diffusion"})
     */
    public function getLocalId(){
        if($this->getLocal()){
            return $this->getLocal()->getId();
        }
        return null;
    }
}
