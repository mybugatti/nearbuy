<?php

namespace NearBuy\DataBundle\DataFixtures\ORM;

use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use NearBuy\DataBundle\Entity\Promotion;
use NearBuy\DataBundle\Entity\Category;
use NearBuy\DataBundle\Entity\Currency;
use NearBuy\DataBundle\Entity\Entreprise;
use NearBuy\DataBundle\Entity\EntrepriseCategory;
use NearBuy\DataBundle\Entity\UserPromotion;
use NearBuy\DataBundle\Entity\User;
use NearBuy\DataBundle\Entity\UserDescription;
use NearBuy\DataBundle\Entity\Local;
use NearBuy\DataBundle\Entity\Diffusion;
use NearBuy\DataBundle\Entity\DiffusionLocal;
use NearBuy\DataBundle\Entity\Reduction;
use NearBuy\DataBundle\Type\ReductionType;
use NearBuy\DataBundle\Type\ValidationType;


/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 20/01/17
 * Time: 17:29
 */
class LoadFixtures extends AbstractFixture implements ContainerAwareInterface
{
    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

    }

    public function load(ObjectManager $em)
    {
        $this->loadEntreprise($em);
        $this->loadCategory($em);
        $this->loadEntrepriseCategory($em);
        $this->loadCurrency($em);
        $this->loadReduction($em);
        $this->loadPromotion($em);
        $this->loadDiffusion($em);
        $this->loadLocal($em);
        $this->loadDiffusionLocal($em);
        $this->loadUser($em);
        $this->loadUserDescription($em);
        $this->loadUserPromotion($em);
    }

    public function loadPromotion(ObjectManager $em)
    {
        $Promotion = new Promotion();
        $Promotion->setId(1);
        $Promotion->setName('Razer BlackWidow');
        $Promotion->setEntreprise($this->getReference('EntRazer'));
        $Promotion->setReduction($this->getReference('Reduc1'));
        $Promotion->setDescription('Le Razer BlackWidow est de retour avec cette version Chroma du premier clavier mécanique développé par le plus célèbre constructeur de périphériques pour gamers.');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::CODE);
        $Promotion->setCategory($this->getReference('Electroniques'));
        $em->persist($Promotion);
        $this->setReference('Razer', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(2);
        $Promotion->setName('Kaporal');
        $Promotion->setEntreprise($this->getReference('EntKaporal'));
        $Promotion->setReduction($this->getReference('Reduc2'));
        $Promotion->setDescription('Les jeans Kaporals sont toujours à la mode');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::CODE);
        $Promotion->setCategory($this->getReference('Vêtements'));
        $em->persist($Promotion);
        $this->setReference('Kaporal', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(3);
        $Promotion->setName('H&M');
        $Promotion->setEntreprise($this->getReference('EntH&M'));
        $Promotion->setReduction($this->getReference('Reduc3'));
        $Promotion->setDescription('Bienvenue chez H&M, votre destination shopping. Nous proposons mode, qualité et durabilité aux meilleurs prix.');
        $Promotion->setLimitUse(3);
        $Promotion->setPromotionType(ValidationType::BARCODE);
        $Promotion->setCategory($this->getReference('Vêtements'));
        $em->persist($Promotion);
        $this->setReference('H&M', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(4);
        $Promotion->setName('Minelli');
        $Promotion->setEntreprise($this->getReference('EntMinelli'));
        $Promotion->setReduction($this->getReference('Reduc4'));
        $Promotion->setDescription('La boutique minelli vous propose une collection de chaussures et maroquinerie femme homme et petite fille toujours très mode.');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::QRCODE_CUSTOMER);
        $Promotion->setCategory($this->getReference('Vêtements'));
        $em->persist($Promotion);
        $this->setReference('Minelli', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(5);
        $Promotion->setName('FNAC');
        $Promotion->setEntreprise($this->getReference('EntFNAC'));
        $Promotion->setReduction($this->getReference('Reduc5'));
        $Promotion->setDescription('Achat Produits culturels, techniques et électroménager. Retrait gratuit en magasin en 1 heure: DVD, jeux vidéo et jouets enfants, cd ...');
        $Promotion->setLimitUse(50);
        $Promotion->setPromotionType(ValidationType::BARCODE);
        $Promotion->setCategory($this->getReference('Autres'));
        $em->persist($Promotion);
        $this->setReference('FNAC', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(6);
        $Promotion->setName('Funky Burger');
        $Promotion->setEntreprise($this->getReference('EntBurger'));
        $Promotion->setReduction($this->getReference('Reduc6'));
        $Promotion->setDescription('Le Funky Burger à Bordeaux vous propose les meilleurs burgers bordelais. Frites, wraps, salades, bières artisanales, viande hachée minute origine france.');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::QRCODE_BUSINESS);
        $Promotion->setCategory($this->getReference('Restaurants'));
        $em->persist($Promotion);
        $this->setReference('Burger', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(7);
        $Promotion->setName('Maison du monde');
        $Promotion->setEntreprise($this->getReference('EntMaison'));
        $Promotion->setReduction($this->getReference('Reduc7'));
        $Promotion->setDescription('Élue enseigne de décoration préférée des Français en 2016, Maisons du monde crée des univers inspirants et originaux pour toute la maison et tous les styles.');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::CODE);
        $Promotion->setCategory($this->getReference('Autres'));
        $em->persist($Promotion);
        $this->setReference('Maison', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(8);
        $Promotion->setName('Lego');
        $Promotion->setEntreprise($this->getReference('EntLego'));
        $Promotion->setReduction($this->getReference('Reduc8'));
        $Promotion->setDescription('Le boutique officiel de la brique de construction avec des liens vers les produits, les jeux, les vidéos, le magasin LEGO®, l\'histoire LEGO, les créations de.');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::CODE);
        $Promotion->setCategory($this->getReference('Autres'));
        $em->persist($Promotion);
        $this->setReference('Lego', $Promotion);

        $Promotion = new Promotion();
        $Promotion->setId(9);
        $Promotion->setName('Nespresso');
        $Promotion->setEntreprise($this->getReference('EntNespresso'));
        $Promotion->setReduction($this->getReference('Reduc9'));
        $Promotion->setDescription('Nespresso propose des Cafés d\'exception et des Machines innovantes pour réaliser des espressos et des recettes lait gourmandes. Rejoignez le Club ...');
        $Promotion->setLimitUse(1);
        $Promotion->setPromotionType(ValidationType::QRCODE_BUSINESS);
        $Promotion->setCategory($this->getReference('Autres'));
        $em->persist($Promotion);
        $this->setReference('Nespresso', $Promotion);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadReduction(ObjectManager $em)
    {
        $Reduction = new Reduction();
        $Reduction->setId(1);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('20');
        $em->persist($Reduction);
        $this->setReference('Reduc1', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(2);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('10');
        $em->persist($Reduction);
        $this->setReference('Reduc2', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(3);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::ABSOLUTE);
        $Reduction->setValue('50');
        $em->persist($Reduction);
        $this->setReference('Reduc3', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(4);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::ABSOLUTE);
        $Reduction->setValue('25');
        $em->persist($Reduction);
        $this->setReference('Reduc4', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(5);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('15');
        $em->persist($Reduction);
        $this->setReference('Reduc5', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(6);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::ABSOLUTE);
        $Reduction->setValue('10');
        $em->persist($Reduction);
        $this->setReference('Reduc6', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(7);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('10');
        $em->persist($Reduction);
        $this->setReference('Reduc7', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(8);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('20');
        $em->persist($Reduction);
        $this->setReference('Reduc8', $Reduction);

        $Reduction = new Reduction();
        $Reduction->setId(9);
        $Reduction->setCurrency($this->getReference('Euro'));
        $Reduction->setType(ReductionType::RELATIVE);
        $Reduction->setValue('10');
        $em->persist($Reduction);
        $this->setReference('Reduc9', $Reduction);

       
    }

    public function loadEntreprise(ObjectManager $em)
    {
        $Entreprise = new Entreprise();
        $Entreprise->setId(1);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setName('Razer');
        $Entreprise->setDescription('Le Razer BlackWidow est de retour avec cette version Chroma du premier clavier mécanique développé par le plus célèbre constructeur de périphériques pour gamers.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntRazer', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('Kaporal');
        $Entreprise->setId(2);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Les jeans Kaporals sont toujours à la mode');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntKaporal', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('H&M');
        $Entreprise->setId(3);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Bienvenue chez H&M, votre destination shopping. Nous proposons mode, qualité et durabilité aux meilleurs prix.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntH&M', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('Minelli');
        $Entreprise->setId(4);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('La boutique minelli vous propose une collection de chaussures et maroquinerie femme homme et petite fille toujours très mode.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntMinelli', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('FNAC');
        $Entreprise->setId(5);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Achat Produits culturels, techniques et électroménager. Retrait gratuit en magasin en 1 heure: DVD, jeux vidéo et jouets enfants, cd ...');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntFNAC', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('Funky Burger');
        $Entreprise->setId(6);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Le Funky Burger à Bordeaux vous propose les meilleurs burgers bordelais. Frites, wraps, salades, bières artisanales, viande hachée minute origine france.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntBurger', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('Maison du monde');
        $Entreprise->setId(7);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Élue enseigne de décoration préférée des Français en 2016, Maisons du monde crée des univers inspirants et originaux pour toute la maison et tous les styles.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntMaison', $Entreprise);

        $Entreprise = new Entreprise();
        $Entreprise->setName('Lego');
        $Entreprise->setId(8);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Le boutique officiel de la brique de construction avec des liens vers les produits, les jeux, les vidéos, le magasin LEGO®, l\'histoire LEGO, les créations de.');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntLego', $Entreprise);#FF9800

        $Entreprise = new Entreprise();
        $Entreprise->setName('Nespresso');
        $Entreprise->setId(9);
        $Entreprise->setSiret('73282932000074');
        $Entreprise->setDescription('Nespresso propose des Cafés d\'exception et des Machines innovantes pour réaliser des espressos et des recettes lait gourmandes. Rejoignez le Club ...');
        $Entreprise->setSchedule('Lundi : 9h00-19h00 / Mardi : 9h00-19h00 / Mercredi : 9h00-19h00 / Jeudi : 9h00-19h00 / Vendredi : 9h00-18h00 / Samedi : 10h00-13h00');
        $em->persist($Entreprise);
        $this->setReference('EntNespresso', $Entreprise);


        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadCategory(ObjectManager $em)
    {
        $Category = new Category();
        $Category->setId(1);
        $Category->setName('Vêtements');
        $Category->setColor('#F48FB1');
        $em->persist($Category);
        $this->setReference('Vêtements', $Category);

        $Category = new Category();
        $Category->setId(2);
        $Category->setName('Electroniques');
        $Category->setColor('#9FA8DA');
        $em->persist($Category);
        $this->setReference('Electroniques', $Category);

        $Category = new Category();
        $Category->setId(3);
        $Category->setName('Bars');
        $Category->setColor('#A5D6A7');
        $em->persist($Category);
        $this->setReference('Bars', $Category);

        $Category = new Category();
        $Category->setId(4);
        $Category->setName('Restaurants');
        $Category->setColor('#EF9A9A');
        $em->persist($Category);
        $this->setReference('Restaurants', $Category);

        $Category = new Category();
        $Category->setId(5);
        $Category->setName('Autres');
        $Category->setColor('#B0BEC5');
        $em->persist($Category);
        $this->setReference('Autres', $Category);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadEntrepriseCategory(ObjectManager $em)
    {
        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(1);
        $EntrepriseCategory->setCategory($this->getReference('Electroniques'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntRazer'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat1', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(2);
        $EntrepriseCategory->setCategory($this->getReference('Vêtements'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntKaporal'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat2', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(3);
        $EntrepriseCategory->setCategory($this->getReference('Vêtements'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntH&M'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat3', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(4);
        $EntrepriseCategory->setCategory($this->getReference('Vêtements'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntMinelli'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat4', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(5);
        $EntrepriseCategory->setCategory($this->getReference('Electroniques'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntFNAC'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat5', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(6);
        $EntrepriseCategory->setCategory($this->getReference('Restaurants'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntBurger'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat6', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(7);
        $EntrepriseCategory->setCategory($this->getReference('Autres'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntMaison'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat7', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(8);
        $EntrepriseCategory->setCategory($this->getReference('Autres'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntLego'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat8', $EntrepriseCategory);

        $EntrepriseCategory = new EntrepriseCategory();
        $EntrepriseCategory->setId(9);
        $EntrepriseCategory->setCategory($this->getReference('Autres'));
        $EntrepriseCategory->setEntreprise($this->getReference('EntNespresso'));
        $em->persist($EntrepriseCategory);
        $this->setReference('entcat9', $EntrepriseCategory);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadCurrency(ObjectManager $em)
    {
        $Currency = new Currency();
        $Currency->setId(1);
        $Currency->setName('Euro');
        $Currency->setCode('EUR');
        $Currency->setSymbol('€');
        $em->persist($Currency);
        $this->setReference('Euro', $Currency);

        $Currency = new Currency();
        $Currency->setId(2);
        $Currency->setName('Dollars');
        $Currency->setCode('USD');
        $Currency->setSymbol('$');
        $em->persist($Currency);
        $this->setReference('Dollars', $Currency);

        $Currency = new Currency();
        $Currency->setId(2);
        $Currency->setName('Pounds');
        $Currency->setCode('GBP');
        $Currency->setSymbol('£');
        $em->persist($Currency);
        $this->setReference('Pounds', $Currency);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadDiffusion(ObjectManager $em)
    {
        $Diffusion = new Diffusion();
        $Diffusion->setId(1);
        $Diffusion->setPromotion($this->getReference('Razer'));
        $Diffusion->setBeginDate(new \DateTime('2017-01-20 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-01-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif1', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(2);
        $Diffusion->setPromotion($this->getReference('Kaporal'));
        $Diffusion->setBeginDate(new \DateTime('2017-02-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-02-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif2', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(3);
        $Diffusion->setPromotion($this->getReference('H&M'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif3', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(4);
        $Diffusion->setPromotion($this->getReference('Minelli'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif4', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(5);
        $Diffusion->setPromotion($this->getReference('FNAC'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif5', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(6);
        $Diffusion->setPromotion($this->getReference('Burger'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif6', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(7);
        $Diffusion->setPromotion($this->getReference('Maison'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif7', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(8);
        $Diffusion->setPromotion($this->getReference('Lego'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif8', $Diffusion);

        $Diffusion = new Diffusion();
        $Diffusion->setId(9);
        $Diffusion->setPromotion($this->getReference('Nespresso'));
        $Diffusion->setBeginDate(new \DateTime('2017-03-15 09:00:00'));
        $Diffusion->setEndDate(new \DateTime('2017-03-25 19:00:00'));
        $em->persist($Diffusion);
        $this->setReference('dif9', $Diffusion);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadLocal(ObjectManager $em)
    {
        $Local = new Local();
        $Local->setId(1);
        $Local->setEntreprise($this->getReference('EntRazer'));
        $Local->setDescription('');
        $Local->setSchedule('Lundi : 9h00-18h30 / Mardi : 10h00-18h30 / Mercredi : 10h00-18h30 / Jeudi : 10h00-18h30 / Vendredi : 10h00-18h00 / Samedi : 10h00-13h00');
        $Local->setAddress('15 Rue de la porte Dijeaux');
        $Local->setCity('Bordeaux');
        $Local->setCp('33000');
        $Local->setLat('44.840864');
        $Local->setLng(' -0.577295');
        $em->persist($Local);
        $this->setReference('local1', $Local);

        $Local = new Local();
        $Local->setId(2);
        $Local->setEntreprise($this->getReference('EntKaporal'));
        $Local->setDescription('');
        $Local->setSchedule('Lundi : 9h00-18h30 / Mardi : 10h00-18h30 / Mercredi : 10h00-18h30 / Jeudi : 10h00-18h30 / Vendredi : 10h00-18h00 / Samedi : 10h00-13h00');
        $Local->setAddress('15 Rue du Temple');
        $Local->setCity('Bordeaux');
        $Local->setCp('33000');
        $Local->setLat('44.841077');
        $Local->setLng('-0.577940');
        $em->persist($Local);
        $this->setReference('local2', $Local);

        $Local = new Local();
        $Local->setId(3);
        $Local->setEntreprise($this->getReference('EntH&M'));
        $Local->setDescription('');
        $Local->setSchedule('Lundi : 9h00-18h30 / Mardi : 10h00-18h30 / Mercredi : 10h00-18h30 / Jeudi : 10h00-18h30 / Vendredi : 10h00-18h00 / Samedi : 10h00-13h00');
        $Local->setAddress('30 rue Saint-Rémi');
        $Local->setCity('Bordeaux');
        $Local->setCp('33000');
        $Local->setLat('44.841313');
        $Local->setLng('-0.571792');
        $em->persist($Local);
        $this->setReference('local3', $Local);

        $Local = new Local();
        $Local->setId(4);
        $Local->setEntreprise($this->getReference('EntMinelli'));
        $Local->setDescription('');
        $Local->setSchedule('Lundi : 9h00-18h30 / Mardi : 10h00-18h30 / Mercredi : 10h00-18h30 / Jeudi : 10h00-18h30 / Vendredi : 10h00-18h00 / Samedi : 10h00-13h00');
        $Local->setAddress('14 rue Ravez');
        $Local->setCity('Bordeaux');
        $Local->setCp('33000');
        $Local->setLat('44.837083');
        $Local->setLng('-0.572704');
        $em->persist($Local);
        $this->setReference('local4', $Local);

        $Local = new Local();
        $Local->setId(5);
        $Local->setEntreprise($this->getReference('EntFNAC'));
        $Local->setDescription('');
        $Local->setSchedule('Lundi : 9h00-18h30 / Mardi : 10h00-18h30 / Mercredi : 10h00-18h30 / Jeudi : 10h00-18h30 / Vendredi : 10h00-18h00 / Samedi : 10h00-13h00');
        $Local->setAddress('50 Rue Sainte-Catherine');
        $Local->setCity('Bordeaux');
        $Local->setCp('33000');
        $Local->setLat('44.841313');
        $Local->setLng('-0.571792');
        $em->persist($Local);
        $this->setReference('local5', $Local);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadDiffusionLocal(ObjectManager $em)
    {
        $DiffusionLocal = new DiffusionLocal();
        $DiffusionLocal->setId(1);
        $DiffusionLocal->setDiffusion($this->getReference('dif1'));
        $DiffusionLocal->setLocal($this->getReference('local1'));
        $em->persist($DiffusionLocal);
        $this->setReference('diflocal1', $DiffusionLocal);

        $DiffusionLocal = new DiffusionLocal();
        $DiffusionLocal->setId(2);
        $DiffusionLocal->setDiffusion($this->getReference('dif2'));
        $DiffusionLocal->setLocal($this->getReference('local2'));
        $em->persist($DiffusionLocal);
        $this->setReference('diflocal2', $DiffusionLocal);

        $DiffusionLocal = new DiffusionLocal();
        $DiffusionLocal->setId(3);
        $DiffusionLocal->setDiffusion($this->getReference('dif3'));
        $DiffusionLocal->setLocal($this->getReference('local3'));
        $em->persist($DiffusionLocal);
        $this->setReference('diflocal3', $DiffusionLocal);

        $DiffusionLocal = new DiffusionLocal();
        $DiffusionLocal->setId(4);
        $DiffusionLocal->setDiffusion($this->getReference('dif4'));
        $DiffusionLocal->setLocal($this->getReference('local4'));
        $em->persist($DiffusionLocal);
        $this->setReference('diflocal4', $DiffusionLocal);

        $DiffusionLocal = new DiffusionLocal();
        $DiffusionLocal->setId(5);
        $DiffusionLocal->setDiffusion($this->getReference('dif5'));
        $DiffusionLocal->setLocal($this->getReference('local5'));
        $em->persist($DiffusionLocal);
        $this->setReference('diflocal5', $DiffusionLocal);

        // actually executes the queries (i.e. the INSERT query)
       

    }

    public function loadUser(ObjectManager $em)
    {
        // Get our userManager, you must implement `ContainerAwareInterface`

        /** @var UserManipulator $userManipulator */
        $userManipulator = $this->container->get('fos_user.util.user_manipulator');

        // Create our user and set details
        /** @var User $User */
        $User = $userManipulator->create('Robert','toto','robert@gmail.com',1,0);
        $em->persist($User);
        $this->setReference('UsrRobert', $User);

        $User = $userManipulator->create('Michelle','toto','michelle@hotmail.fr',1,0);
        $em->persist($User);
        $this->setReference('UsrMichelle', $User);

        $User = $userManipulator->create('Pauline','toto','Pauline-Fnac@gmail.com',1,0);
        $em->persist($User);
        $this->setReference('UsrPauline', $User);

        $User = $userManipulator->create('Patrick','toto','Patrickleroi@gmail.com',1,0);
        $em->persist($User);
        $this->setReference('UsrPatrick', $User);

        $User = $userManipulator->create('Kevin','toto','Kevin@laposte.net',1,0);
        $em->persist($User);
        $this->setReference('UsrKevin', $User);

    }

    public function loadUserDescription(ObjectManager $em)
    {
        $UserDescription = new UserDescription();
        $UserDescription->setId(1);
        $UserDescription->setBirthdate(new \DateTime('1962-09-17'));
        $UserDescription->setGender('Male');
        $UserDescription->setCity('Bordeaux');
        $UserDescription->setUser($this->getReference('UsrRobert'));
        $em->persist($UserDescription);
        $this->setReference('DescRobert', $UserDescription);

        $UserDescription = new UserDescription();
        $UserDescription->setId(2);
        $UserDescription->setBirthdate(new \DateTime('1968-04-06'));
        $UserDescription->setGender('Female');
        $UserDescription->setCity('Bordeaux');
        $UserDescription->setUser($this->getReference('UsrMichelle'));
        $em->persist($UserDescription);
        $this->setReference('DescMichelle', $UserDescription);

        $UserDescription = new UserDescription();
        $UserDescription->setId(3);
        $UserDescription->setBirthdate(new \DateTime('1988-12-01'));
        $UserDescription->setGender('Female');
        $UserDescription->setCity('Bordeaux');
        $UserDescription->setUser($this->getReference('UsrPauline'));
        $em->persist($UserDescription);
        $this->setReference('DescPauline', $UserDescription);

        $UserDescription = new UserDescription();
        $UserDescription->setId(4);
        $UserDescription->setBirthdate(new \DateTime('1981-07-28'));
        $UserDescription->setGender('Male');
        $UserDescription->setCity('Bordeaux');
        $UserDescription->setUser($this->getReference('UsrPatrick'));
        $em->persist($UserDescription);
        $this->setReference('DescPatrick', $UserDescription);

        $UserDescription = new UserDescription();
        $UserDescription->setId(5);
        $UserDescription->setBirthdate(new \DateTime('1976-02-20'));
        $UserDescription->setGender('Male');
        $UserDescription->setCity('Bordeaux');
        $UserDescription->setUser($this->getReference('UsrKevin'));
        $em->persist($UserDescription);
        $this->setReference('DescKevin', $UserDescription);

    }

    public function loadUserPromotion(ObjectManager $em)
    {
        $UserPromotion = new UserPromotion();
        $UserPromotion->setId(1);
        $UserPromotion->setPromotion($this->getReference('Kaporal'));
        $UserPromotion->setUser($this->getReference('UsrRobert'));
        $UserPromotion->setNbUsed('1');
        $em->persist($UserPromotion);
        $this->setReference('PromoRobert', $UserPromotion);

        $UserPromotion = new UserPromotion();
        $UserPromotion->setId(2);
        $UserPromotion->setPromotion($this->getReference('H&M'));
        $UserPromotion->setUser($this->getReference('UsrMichelle'));
        $UserPromotion->setNbUsed('1');
        $em->persist($UserPromotion);
        $this->setReference('PromoMichelle', $UserPromotion);

        $UserPromotion = new UserPromotion();
        $UserPromotion->setId(3);
        $UserPromotion->setPromotion($this->getReference('Lego'));
        $UserPromotion->setUser($this->getReference('UsrPauline'));
        $UserPromotion->setNbUsed('1');
        $em->persist($UserPromotion);
        $this->setReference('PromoPauline', $UserPromotion);

        $UserPromotion = new UserPromotion();
        $UserPromotion->setId(4);
        $UserPromotion->setPromotion($this->getReference('Burger'));
        $UserPromotion->setUser($this->getReference('UsrPatrick'));
        $UserPromotion->setNbUsed('1');
        $em->persist($UserPromotion);
        $this->setReference('PromoPatrick', $UserPromotion);

        $UserPromotion = new UserPromotion();
        $UserPromotion->setId(5);
        $UserPromotion->setPromotion($this->getReference('FNAC'));
        $UserPromotion->setUser($this->getReference('UsrKevin'));
        $UserPromotion->setNbUsed('1');
        $em->persist($UserPromotion);
        $this->setReference('PromoKevin', $UserPromotion);

        $em->flush();
    }
}