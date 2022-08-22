<?php

namespace App\Form;

use App\Entity\Permission;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isSellDrinks',null, [
                'label'    => 'Peut-il vendre des boissons ?',
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
            'data_class' => Permission::class,
        ]);
    }
}
