<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('role')
            ->add('rank')
            ->add('number', null, [
                'label' => 'Badge number'
            ])
            ->add('birthdate' ,null, [
                'widget' => 'single_text'
            ])
            ->add('uid')
            ->add('legal_text')
            ->add('role_type')
            ->add('to_print')
            ->add('employee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
