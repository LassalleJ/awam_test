<?php

namespace App\Form;

use App\Entity\Currency;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ConvertType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value_one', NumberType::class, [
                'label' => 'Montant 1',
                'required' => true,
            ])
            ->add('currency_one', EntityType::class, [
                'class' => Currency::class,
                'label' => 'Devise',
                'choice_label' => 'code',
                'required' => true,
            ])
            ->add('operand', ChoiceType::class, [
                'choices' => [
                    '+' => '+',
                    '-' => '-'
                ],
                'label' => 'Opération'
            ])
            ->add('value_two', NumberType::class, [
                'label' => 'Montant 2',
                'required' => true
            ])
            ->add('currency_two', EntityType::class, [
                'label' => 'Devise',
                'class' => Currency::class,
                'choice_label' => 'code',
                'required' => true
            ])
            ->add('currency_result', EntityType::class, [
                'label' => 'Devise',
                'class' => Currency::class,
                'choice_label' => 'code',
                'required' => true
            ])
            ->add('save', CheckboxType::class, [
                'label' => 'Enregistrer le calcul'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Calculer'
            ])
            ;
    }

}