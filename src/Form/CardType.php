<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('number', NumberType::class, [
                'label' => 'Badge number',
                'required' => false
            ])
            ->add('uid', null, [
                'help' => "Unique Identifier"
            ])
            ->add('legalText', TextareaType::class, [
                'help' => 'Ce texte apparaît au dos de la carte et définit les droits et attributions que confère la carte à son détenteur en fonction de son rôle au sein de la PRM.',
                'attr' => [
                    'style' => 'min-height: auto;'
                ]
            ])
            ->add('roleType', ChoiceType::class, [
                'choices' => [
                    'Civil' => 'Civil',
                    'Police' => 'Police'
                ]
            ])
            ->add('toPrint', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
