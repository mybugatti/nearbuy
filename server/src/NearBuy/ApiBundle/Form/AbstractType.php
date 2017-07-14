<?php

namespace NearBuy\ApiBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType as OriginalType;

class AbstractType extends OriginalType
{
    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * AbstractType constructor.
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
}
