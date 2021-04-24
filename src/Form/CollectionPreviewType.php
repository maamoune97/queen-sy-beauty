<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\HomePageCollectionPreview;
use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CollectionPreviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => "Image de la collection",
                'help' => "l'image doit être au format jpg ou png et la taille maximal 5 Mo ",
                'mapped' => false,
                'required' => false,
                'constraints' => [                    
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Selectionnez une image au format jpg ou png',
                    ]), 
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Selectionner une ',
                'label' => 'Categorie'
            ])
            ->add('subCategories', EntityType::class, [
                'class' => SubCategory::class,
                // 'choices' => null,
                'choice_label' => 'name',
                'data' => null,
                'multiple' => true,
                'label' => 'Sous-categories',
                'attr' => [
                    'class' => 'js-example-basic-multiple'
                ]
            ])
            ->add('products', EntityType::class, [
                'class' => Product::class,
                // 'choices' => null,
                'choice_label' => 'name',
                'multiple' => true,
                'data' => null,
                'label' => 'Articles',
                'attr' => [
                    'class' => 'js-example-basic-multiple'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HomePageCollectionPreview::class,
        ]);
    }
}
