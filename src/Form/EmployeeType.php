<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rank')
            ->add('firstname')
            ->add('lastname')
            ->add('birthdate', null, [
                'widget' => "single_text"
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Non défini' => 0,
                    'Femme' => 1,
                    'Homme' => 2
                ]
            ])
            ->add('role')
            ->add('phone_number')
            ->add('email')
            ->add('pictureFile', VichImageType::class)
            ->add('badge_number')
            ->add('isPolice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
