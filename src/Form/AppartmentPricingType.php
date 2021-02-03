<?php

namespace App\Form;

use App\Entity\Appartment;
use App\Entity\AppartmentPricing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppartmentPricingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('price')
            ->add('ID_Appartment', "entity", [
                // looks for choices from this entity
                'class' => Appartment::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'number',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AppartmentPricing::class,
        ]);
    }
}
