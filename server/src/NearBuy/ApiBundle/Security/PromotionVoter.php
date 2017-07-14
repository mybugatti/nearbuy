<?php

namespace NearBuy\ApiBundle\Security;

use NearBuy\DataBundle\Entity\Promotion;
use NearBuy\DataBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PromotionVoter extends AbstractVoter
{

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::SHOW, self::EDIT, self::DELETE))) {
            return false;
        }

        // only vote on Promotion objects inside this voter
        if (!$subject instanceof Promotion) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Promotion $promotion */
        $promotion = $subject;

        switch ($attribute) {

            case self::SHOW:
                return $this->canShow($promotion, $user);
            case self::EDIT:
                return $this->canEdit($promotion, $user);
            case self::DELETE:
                return $this->canDelete($promotion, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canShow(Promotion $promotion, User $user)
    {
        return $this->userAuthorization->readPromotion($promotion->getEntreprise(), $user);
    }

    private function canEdit(Promotion $promotion, User $user)
    {
        return $this->userAuthorization->writePromotion($promotion->getEntreprise(), $user);
    }

    private function canDelete(Promotion $promotion, User $user)
    {
        return $this->userAuthorization->writePromotion($promotion->getEntreprise(), $user);
    }
}