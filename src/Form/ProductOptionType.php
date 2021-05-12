<?php

namespace App\Form;

use App\Entity\ProductOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('type', ChoiceType::class, [
        //     'label' => "Type d'option",
        //     'choices'  => [
        //         'Couleur' => 'color',
        //         'Taille' => 'size',
        //     ],
        // ])
        ->add('type', HiddenType::class, [
            
        ])
        ->add('productOptionFields', CollectionType::class, [
            'entry_type' => ProductOptionFieldType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'label' => 'Propriétés de l\'option',
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
