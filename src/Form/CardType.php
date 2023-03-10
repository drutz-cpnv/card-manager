<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('uid', null, [
                'help' => "Unique Identifier"
            ])
            ->add('legal_text', null, [
                'help' => 'This text appears on the back of the card and defines the rights and powers conferred by the card on its holder.'
            ])
            ->add('role_type', ChoiceType::class, [
                'choices' => [
                    'Civil' => 'Civil',
                    'Police' => 'Police'
                ]
            ])
            ->add('to_print')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
