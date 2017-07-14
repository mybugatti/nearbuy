<?php

namespace NearBuy\ApiBundle\Form;

use NearBuy\ApiBundle\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('code')
            ->add('limitUse')
            ->add('promotionType')
            ->add('entreprise')
            ->add('reduction')
            ->add('category');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NearBuy\DataBundle\Entity\Promotion',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nearbuy_apibundle_promotion';
    }


}
