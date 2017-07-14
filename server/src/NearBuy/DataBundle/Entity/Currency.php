<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Currency
 *
 * @ORM\Table(name="currency")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Currency
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
gb     * @JMS\Groups({"currency", "promotion"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"currency", "promotion"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"currency", "promotion"})
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=10, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Groups({"currency", "promotion"})
     */
    private $symbol;



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
     * @return Currency
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
     * Set code
     *
     * @param string $code
     *
     * @return Currency
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
     * Set symbol
     *
     * @param string $symbol
     *
     * @return Currency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
