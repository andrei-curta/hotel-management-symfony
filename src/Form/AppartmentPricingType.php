<?php

namespace App\Form;

use App\Entity\Appartment;
use App\Entity\AppartmentPricing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('ID_Appartment', EntityType::class, [
                // looks for choices from this entity
                'class' => Appartment::class,
                'label'=> 'Appartment no'
                // uses the User.username property as the visible option string
                //'choice_label' => 'appartment.number',

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

//->add('trainer', EntityType::class, array('label'=> 'Antrenor', 'class' => 'App:Trainers', 'choice_label' => 'user.name', 'attr'=> array('class' => 'form-control', 'style' => 'margin-bottom:15px')));