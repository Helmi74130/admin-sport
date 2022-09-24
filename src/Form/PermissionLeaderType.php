<?php

namespace App\Form;

use App\Entity\PermissionLeader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionLeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isSellDrinks',null, [
                'label'    => 'Peut-il vendre des boissons ?',
                'attr' => [
                    'id' => 'flexSwitchCheckChecked'
                ]
            ])
            ->add('isMembersWrite', null, [
                'label'    => 'Peut-il modifier un membre ?',
            ])
            ->add('isMembersRead', null, [
                'label'    => 'Peut-il avoir accés à un membre ?',
            ])
            ->add('isMembersAdd', null, [
                'label'    => 'Peut-il ajouter un membre ?',
            ])
            ->add('isMembersStatistiqueRead', null, [
                'label'    => 'Peut-il voir les statistique d\'un membre ?',
            ])
            ->add('isPaymentSchedulesWrite', null, [
                'label'    => 'Peut-il avoir accés aux échéanciés de paiement ?',
            ])
            ->add('isPaymentSchedulesAdd', null, [
                'label'    => 'Peut-il ajouter un échéancié de paiement ?',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PermissionLeader::class,
        ]);
    }
}
