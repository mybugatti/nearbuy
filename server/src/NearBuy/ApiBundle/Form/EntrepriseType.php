<?php

namespace NearBuy\ApiBundle\Form;

use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use NearBuy\ApiBundle\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('siret')
            ->add('description')
            ->add('schedule')
            ->add('entrepriseCategory', CollectionType::class, array(
                'required' => false,
                'entry_type' => EntrepriseCategoryType::class,
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
            'data_class' => 'NearBuy\DataBundle\Entity\Entreprise',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nearbuy_apibundle_entreprise';
    }


}
