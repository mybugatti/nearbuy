<?php

namespace NearBuy\ApiBundle\Form;

use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use NearBuy\ApiBundle\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Date;

class DiffusionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginDate', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm:ss',
                'date_format' => 'yyyy-MM-dd HH:mm:ss'
            ))
            ->add('endDate', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm:ss',
                'date_format' => 'yyyy-MM-dd HH:mm:ss'
            ))
            ->add('promotion')
            ->add('diffusionLocal', CollectionType::class, array(
                'required' => false,
                'entry_type' => DiffusionLocalType::class,
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
            'data_class' => 'NearBuy\DataBundle\Entity\Diffusion',
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nearbuy_apibundle_diffusion';
    }


}
