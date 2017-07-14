<?php

namespace NearBuy\ApiBundle\Security;

use NearBuy\ApiBundle\Util\UserAuthorization;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractVoter extends Voter
{

    const SHOW = 'show';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @var $userAuthorization UserAuthorization
     */
    protected $userAuthorization;

    public function __construct(UserAuthorization $userAuthorization){
        $this->userAuthorization = $userAuthorization;
    }

}