<?php

namespace App\Form;

use App\Entity\Leader;;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]

            ])
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('mail', EmailType::class, [
                'label'=> 'E-mail *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '50'
                ]
            ])
            ->add('city', TextType::class, [
                'label'=> 'Ville *',
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '80'
                ]
            ])
            ->add('phone', TelType::class, [
                'label'=> 'Tél. *',
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '15'
                ]
            ])
            ->add('commercialPhone', TelType::class, [
                'label'=> 'Tél. commercial',
                'required' => false,
                'attr' => [
                    'minlength' => '10',
                    'maxlength' => '15'
                ]
            ])
            ->add('isActive', null, [
                'label'=> 'En activité *'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Leader::class,
        ]);
    }
}
