<?php

namespace App\Form;

use App\Entity\Cards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom de la carte'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 70,
                        'minMessage' => 'Votre catégorie doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre catégorie ne doit pas contenir plus de {{ limit }} caractères.'
                        ])
                    ],
                    ])
            ->add('quantite', TextType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Veuillez saisir le nombre d\'exemplaire de la carte'
                    ])
                    ],
            ])
            ->add('value', TextType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Veuillez saisir la valeur de la carte'
                    ])
                    ],
            ])
            ->add('image', FileType::class,[
                'data_class' => null,
                'required' =>true,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024K'
                    ])
                ]
            ])
            ->add('inSell', CheckboxType::class, [
                'required' => false
            ])
        
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer une description pour votre carte'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => "Votre description doit au moins contenir {{ limit }} caractères."
                    ])
                ]
            ]) 
            ->add('buyAt')
            ->add('sellAt')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cards::class,
        ]);
    }
}
