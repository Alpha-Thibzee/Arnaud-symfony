<?php

namespace App\Form;

use App\Entity\Cards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MailerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('nom', TextType::class,[
                'label' => 'Votre Nom : ',
             ])
             ->add('email', EmailType::class,[
                'label' => 'Votre Email : ',
             ])
            ->add('value', IntegerType::class, [
                'label' => 'Prix de votre offre',
                'attr' => ['min' => ""],
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => MailerType::class,
            //  enable/disable CSRF protection for this form
            // 'csrf_protection' => true,
            //  the name of the hidden HTML field that stores the token
            // 'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            //  using a different string for each form improves its security
            // 'csrf_token_id'   => 'cards_item',
        
        ]);
    }
    

}