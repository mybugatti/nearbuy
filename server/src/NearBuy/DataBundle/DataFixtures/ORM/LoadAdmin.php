<?php

namespace NearBuy\DataBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAdmin implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * @var $um \FOS\UserBundle\Util\UserManipulator
         */
        $um = $this->container->get('fos_user.util.user_manipulator');

        $um->create('admin','123456','admin@mail.com',true,true);
    }
}