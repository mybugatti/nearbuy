<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Local
 *
 * @ORM\Table(name="local", indexes={@ORM\Index(name="fk_local_entreprise1_idx", columns={"entreprise_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Local
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"local", "diffusionLocal", "promotion"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="text", length=65535, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"local", "diffusionLocal", "promotion"})
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"local", "diffusionLocal", "promotion"})
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=5, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     */
    private $cp;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     */
    private $lng;

    /**
     * @var \NearBuy\DataBundle\Entity\Entreprise
     *
     * @JMS\Expose
     * @JMS\Groups({"local"})
     *
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="locals")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * })
     */
    private $entreprise;

    /**
     * @ORM\OneToMany(targetEntity="DiffusionLocal", mappedBy="local")
     *
     * @JMS\Expose
     * @JMS\SerializedName("relatedDiffusions")
     * @JMS\Groups({"local"})
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
     * Set address
     *
     * @param string $address
     *
     * @return Local
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Local
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return Local
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

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
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }



    /**
     * Set entreprise
     *
     * @param \NearBuy\DataBundle\Entity\Entreprise $entreprise
     *
     * @return Local
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
     * Add diffusionLocal
     *
     * @param \NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal
     *
     * @return Local
     */
    public function addDiffusionLocal(\NearBuy\DataBundle\Entity\DiffusionLocal $diffusionLocal)
    {
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
