<?php

namespace App\Form;

use App\Entity\OrderSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('waitingStatus', CheckboxType::class, [
                'label' => 'En attente',
                'attr' => [
                    //'checked' => 'checked'
                ],
                'required' => false
            ])
            ->add('paidStatus', CheckboxType::class, [
                'label' => 'Paiment confirmé',
                'required' => false
            ])
            ->add('receivedStatus', CheckboxType::class, [
                'label' => 'Delivrée',
                'required' => false
            ])
            ->add('allStatus', CheckboxType::class, [
                'label' => 'Tous',
                'required' => false
            ])
            ->add('sort',ChoiceType::class,
                [
                    'label_attr' => [
                        'class' => 'radio-inline'
                    ],
                    'choices' => [
                        'Date croissant' => '1',
                        'Prix décroissant' => '2',
                        'Prix croissant' => '3',
                        'Date décroissant' => '4',
                        ],
                    //'choices_as_values' => true,
                    'multiple'=>false,
                    'expanded'=>true,
                    'choice_attr' => [
                        'Date croissant' => ['checked' => 'checked'],
                    ],
                    // 'required' => false
                ])
            ->add('client', TextType::class, [
                'label' => 'Client',
                'attr' => [
                    'placeholder' => 'nom, prénom ou téléphone'
                ],
                'required' => false
            ])
            ->add('dateMin', DateType::class, [
                'label' => 'Date minimum',
                'required' => false,
                'widget' => 'single_text',
                // 'format' => 'dd-MM-yyyy',
            ])
            ->add('dateMax', DateType::class, [
                'label' => 'Date maximum',
                'required' => false,
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderSearch::class,
        ]);
    }
}
