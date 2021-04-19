<?php

namespace App\Form;

use App\Entity\ProductOptionField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOptionFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du champ',
                'attr' => [
                    'placeholder' => 'Ex: XL'
                ]
            ])
            ->add('addedPrice', MoneyType::class, [
                'label' => 'supplement',
                'currency' => 'KMF',
                'empty_data' => '0',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: 1500'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductOptionField::class,
        ]);
    }
}
