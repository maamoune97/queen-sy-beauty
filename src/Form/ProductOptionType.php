<?php

namespace App\Form;

use App\Entity\ProductOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom de l'option",
            'attr' => [
                'placeholder' => 'Ex: Taille, Couleur, ...'
            ],
        ])
        ->add('type', ChoiceType::class, [
            'label' => "Type de l'option",
            'choices'  => [
                'Obligatoire' => 'required',
                'Facultative' => 'optional',
            ],
        ])
        ->add('productOptionFields', CollectionType::class, [
            'entry_type' => ProductOptionFieldType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'label' => 'Champs d\'option',
            'attr' => [
                
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductOption::class,
        ]);
    }
}
