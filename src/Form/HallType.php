<?php

namespace App\Form;

use App\Entity\Hall;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la salle *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '150'
                ]

            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Courte déscription',
                'required' => false,
                'attr' => [
                    'minlength' => '2'
                ]
            ])
            ->add('streetNumber', IntegerType::class, [
                'label' => 'N° de rue',
                'attr' => [
                    'minlength' => 1,
                    'maxlength' => 10
                ]
            ])
            ->add('adress', TextareaType::class, [
                'label'=> 'Adresse'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '150'
                ]
            ])
            ->add('isactive', null, [
                'label' => 'En activitée'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '12'
                ]
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postale',
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '6'
                ]
            ])
            ->add('permissions',null, [
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hall::class,
        ]);
    }
}
