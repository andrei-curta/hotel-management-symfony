<?php

namespace App\Form;

use App\Entity\Appartment;
use App\Entity\Facility;
use App\Repository\FacilityRepository;
use ContainerJZYVsiV\getFacilityRepositoryService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppartmentType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $facilities = $options['facilities'];

        echo $facilities[0]->getName();

        $builder
            ->add('description')
            ->add('numberOfRooms')
            ->add('image')
            ->add('facilities', FacilityType::class, [
                'choices' => $facilities,
                // "name" is a property path, meaning Symfony will look for a public
                // property or a public method like "getName()" to define the input
                // string value that will be submitted by the form
                'choice_value' => 'name',
                'by_reference' => false,
                // a callback to return the label for a given choice
                // if a placeholder is used, its empty value (null) may be passed but
                // its label is defined by its own "placeholder" option
                'choice_label' => function(?Facility $facility) {
                    return $facility ? strtoupper($facility->getName()) : '';
                },
                // returns the html attributes for each option input (may be radio/checkbox)
                'choice_attr' => function(?Facility $facility) {
                    return $facility ? ['class' => 'facility_'.strtolower($facility->getName())] : [];
                },

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appartment::class,
        ]);

        $resolver->setRequired('facilities');
    }
}
