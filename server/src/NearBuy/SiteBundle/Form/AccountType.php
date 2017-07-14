<?php

namespace NearBuy\SiteBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use NearBuy\ApiBundle\Form\CategoryType;
use NearBuy\ApiBundle\Form\UserDescriptionType;
use NearBuy\DataBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class AccountType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NearBuy\DataBundle\Entity\User',
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nearbuy_sitebundle_account';
    }

    protected $om;

    public function __construct(ObjectManager $om, $user)
    {
        $this->om = $om;
        parent::__construct($user);
    }
}
