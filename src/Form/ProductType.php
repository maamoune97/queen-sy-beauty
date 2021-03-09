<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'article",
                'attr' => [
                    'placeholder' => "ex: chemise de nuit"
                ]
            ])
            ->add('coverImage', FileType::class, [
                'label' => "Image de couverture",
                'help' => "l'image doit être au format jpg ou png et la taille maximal est 3 Mo ",
                'mapped' => false,
                'required' => false,
                'constraints' => [                    
                    new File([
                        'maxSize' => '3M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Selectionnez une image au format jpg ou png',
                    ]),
                    
                ],
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Visible sur la boutique',
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'ckeditor',
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'KMF',
                'attr' => [
                    'placeholder' => 'ex: 2500'
                ]
            ])
            ->add('subCategories', EntityType::class, [
                'label' => 'Categories',
                'class' => SubCategory::class,
                'choice_label' => 'name',
                'multiple' => true,
                'placeholder' => 'Selectionnez le(s) categorie(s)',
                'attr' => [
                    'class' => 'js-example-basic-multiple',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
