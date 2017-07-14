<?php

namespace NearBuy\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NearBuy\ApiBundle\Entity\Client;
use NearBuy\ApiBundle\NearBuyApiBundle;
use OAuth2\OAuth2;

class LoadOAuthClientData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $client = new Client();

        //force tokens and id
        $client->setId(1);
        $client->setRandomId(NearBuyApiBundle::ClientRandomId);
        $client->setSecret(NearBuyApiBundle::ClientSecret);

        //set user credentials as grant type
        $client->setAllowedGrantTypes(array(OAuth2::GRANT_TYPE_USER_CREDENTIALS));

        $manager->persist($client);
        $manager->flush();
    }
}