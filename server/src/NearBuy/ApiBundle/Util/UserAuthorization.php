<?php

namespace NearBuy\ApiBundle\Util;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use NearBuy\DataBundle\Entity\Entreprise;
use NearBuy\DataBundle\Type\EmploymentRoleType;

/**
 * Class UserAuthorization
 *
 * Provides methods aiming to test user's authorization to do an action in a given entreprise.
 *
 * @package NearBuy\ApiBundle\Util
 */
class UserAuthorization
{

    /**
     * @var $em EntityManager
     */
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    /**
     * @param Entreprise $entreprise
     * @return bool
     */
    public function readPromotion(Entreprise $entreprise, $user){

        /* is super admin */
        if($user instanceof UserInterface && in_array('ROLE_SUPER_ADMIN',$user->getRoles())){
            return true;
        }
        /* Employed in the entreprise with any role */
        elseif($user instanceof UserInterface && count($this->em->getRepository('NearBuyDataBundle:Employment')->findBy(array('entreprise' => $entreprise, 'user' => $user)))){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @param Entreprise $entreprise
     * @return bool
     */
    public function writePromotion(Entreprise $entreprise, $user){
        /* is super admin */
        if($user instanceof UserInterface && in_array('ROLE_SUPER_ADMIN',$user->getRoles())){
            return true;
        }
        /* Employed in the entreprise as CEO or commercial */
        elseif($user instanceof UserInterface && count($this->em->getRepository('NearBuyDataBundle:Employment')->findBy(array('entreprise' => $entreprise, 'user' => $user, 'role' => array(EmploymentRoleType::CEO, EmploymentRoleType::COMMERCIAL))))){
            return true;
        }
        else{
            return false;
        }
    }
}