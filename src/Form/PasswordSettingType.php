<?php

namespace App\Form;

use App\Entity\PasswordSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actual', PasswordType::class,[
                'label' => 'Mot de passe actuel',
                // 'empty_data' => '',
                'attr' => [
                    'placeholder' => '***********'
                ],
            ])
            ->add('new', PasswordType::class,[
                'label' => 'Nouveau de mot de passe',
                // 'empty_data' => '',
                'attr' => [
                    'placeholder' => '***********'
                ],
            ])
            ->add('confirm', PasswordType::class,[
                'label' => 'Confirmez votre nouveau mot de passe',
                // 'empty_data' => '',
                'attr' => [
                    'placeholder' => '***********'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PasswordSetting::class,
        ]);
    }
}
