<?php

namespace App\Form;

use App\Entity\ProductFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sizes', ChoiceType::class, [
                'choices' => [
                    'S' => 's',
                    'M' => 'm',
                    'L' => 'l',
                    'XL' => 'xl',
                    'XXL' => 'xxl',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('minPrice', TextType::class, [
                'label' => 'prix min',
                'required' => false,
            ])
            ->add('maxPrice', TextType::class, [
                'label' => 'prix max',
                'required' => false,
            ])
            ->add('colors', ChoiceType::class, [
                'choices' => [
                    'Noir' => 'noir',
                    'Rouge' => 'rouge',
                    'Bleu' => 'bleu',
                    'Vert' => 'Vert',
                    'Blanc' => 'blanc',
                    'Jaune' => 'jaune',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'formatPrices']
            )
        ;
    }

    /**
     * remove KMF currency from the price
     *
     * @param FormEvent $event
     * @return void
     */
    public function formatPrices(FormEvent $event): void
    {
        $productFilter = $event->getData();
        
        $productFilter['minPrice'] =  intval( substr($productFilter['minPrice'],0,-4) ) ?? $productFilter['minPrice'];
        $productFilter['maxPrice'] = intval( substr($productFilter['maxPrice'],0,-4) ) ?? $productFilter['maxPrice'];

       $event->setData($productFilter);

    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            // 'data_class' => ProductFilter::class
        ]);
    }
}
