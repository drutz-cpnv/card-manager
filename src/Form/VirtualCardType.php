<?php

namespace App\Form;

use App\Data\RoleData;
use App\Data\VCardData;
use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VirtualCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameDisplayType', ChoiceType::class, [
                'choices' => $this->getChoices($builder->getData()),
                'choice_attr' => $this->getChoicesAttributes($builder->getData())
            ])
            ->add('email', EmailType::class)
            ->add('phoneNumber')
            ->add('displayRank', CheckboxType::class)
            ->add('displayRole', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VCardData::class,
        ]);
    }

    /**
     * @return array<ChoiceView>
     */
    private function getChoices(VCardData $data): array
    {
        $out = [];
        foreach ($data->getDisplayModeChoices() as $key => $displayModeChoice) {
            $out[$displayModeChoice] = $key;
        }
        return $out;
    }

    /**
     * @return array<ChoiceView>
     */
    private function getChoicesAttributes(VCardData $data): array
    {
        $out = [];
        foreach ($data->getDisplayModeChoices() as $key => $displayModeChoice) {
            if ($key === 2 && is_null($data->getEmployee()->getBadgeNumber())) {
                $out[$displayModeChoice] = [
                    'disabled' => true
                ];
            }
        }
        return $out;
    }
}
