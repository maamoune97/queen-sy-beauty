<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PlaceOrderType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lName', TextType::class, [
                'label' => 'Nom',
                'disabled' => $this->disabledIfConnected(),
            ])
            ->add('fName', TextType::class, [
                'label' => 'Prénom',
                'disabled' => $this->disabledIfConnected(),
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'disabled' => $this->disabledIfConnected(),
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'disabled' => $this->disabledIfConnected(),
            ])
            ->add('deliveryAddress', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Ex: M\'jihari Mutsamudu Anjouan',
                ]
            ])
            ->add('password', $this->hiddenIfConnected(PasswordType::class), [
                'label' => 'Mot de passe',
                'disabled' => $this->disabledIfConnected(),
                'required' => false
            ])
            ->add('passwordConfirm', $this->hiddenIfConnected(PasswordType::class), [
                'label' => 'Confirmation mot de passe',
                'disabled' => $this->disabledIfConnected(),
                'required' => false
            ])
            ->add('createAccount', $this->hiddenIfConnected(CheckboxType::class), [
                'label' => 'Créer un compte',
                'disabled' => $this->disabledIfConnected(),
                'required' => false
            ])
            ->add('paymentMode', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'Paiement par mvoula' => 1,
                    'Paiement lors de la recupération' => 2,
                ],
                'multiple'=> false,
                'expanded'=> true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    private function disabledIfConnected(): bool
    {
        return $this->security->getUser() ? true : false;
    }

    private function hiddenIfConnected(string $type): string
    {
        return $this->security->getUser() ? HiddenType::class : $type;
    }
}
