<?php

namespace App\Form;

use App\Entity\ContactUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactUsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fullName', TextType::class, [
            'label' => 'Nom & Prénom',
            'attr' => [
                'placeholder' => 'Votre nom & prénom'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'attr' => [
                'placeholder' => 'Votre email'
            ]
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'attr' => [
                'placeholder' => 'Votre message'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => ContactUs::class,
        ]);
    }
}
