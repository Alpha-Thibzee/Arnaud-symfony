<?php

namespace App\Form;

use App\Entity\Cards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prix', ChoiceType::class, [
            'choices' => [
                'Croissant' => true,
                'Décroisant' => false,    
            ],
            'mapped' => false,
            'required' =>false,
            'attr' => [
            'class' => 'form-control',
            ]
        ])
        ->add('send', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary m-4']
        ])
    ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cards::class,
        ]);
    }
}
