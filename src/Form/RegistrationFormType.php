<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'ex: Ben Omar'
                ]
            ])
            ->add('fName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'ex: Maamoune'
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'ex: 3218694'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'ex: maamoune@exemple.com'
                ]
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'label' => 'Termes & Conditions',
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'Vous devez accepter les termes et conditions',
            //         ]),
            //     ],
            // ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => '***********'
                ],
            ])
            ->add('passwordConfirmation', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Confirmation du mot de passe',
                'attr' => [
                    'placeholder' => '***********'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Registration']
        ]);
    }
}
