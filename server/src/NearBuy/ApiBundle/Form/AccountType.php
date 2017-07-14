<?php

namespace NearBuy\ApiBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        $builder->add('business', ChoiceType::class, array(
            'choices' => array(true,false),
            'choices_as_values' => true,
            'expanded' => false,
            'required' => false))
            ->add('descriptions', CollectionType::class, array(
                'required' => false,
                'entry_type' => UserDescriptionType::class,
                'by_reference' => true,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('favouriteCategories', CollectionType::class, array(
                'required' => false,
                'entry_type' => CategoryType::class,
                'by_reference' => true,
                'allow_add' => true,
                'allow_delete' => true
            ));
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
        return 'nearbuy_apibundle_account';
    }

    protected $om;

    public function __construct(ObjectManager $om, $user)
    {
        $this->om = $om;
        parent::__construct($user);
    }
}
