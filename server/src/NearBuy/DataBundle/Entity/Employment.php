<?php

namespace NearBuy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Employment
 *
 * @ORM\Table(name="employment", indexes={@ORM\Index(name="fk_table1_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_table1_entreprise1_idx", columns={"entreprise_id"})})
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Employment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise","user"})
     */
    private $id;

    /**
     * @var \NearBuy\DataBundle\Entity\Entreprise
     *
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="employments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * })
     *
     * @JMS\Expose
     * @JMS\Groups({"user"})
     */
    private $entreprise;

    /**
     * @var \NearBuy\DataBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="employments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="EmploymentRoleType", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"entreprise","user"})
     */
    private $role;

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
     * Set entreprise
     *
     * @param \NearBuy\DataBundle\Entity\Entreprise $entreprise
     *
     * @return Employment
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
     * Set user
     *
     * @param \NearBuy\DataBundle\Entity\User $user
     *
     * @return Employment
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
     * Set role
     *
     * @param string $role
     *
     * @return Employment
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}
