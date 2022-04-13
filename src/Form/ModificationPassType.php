<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificationPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'required' => true,
                ])

            ->add('passwordmodification', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => 'Nouveau mot de passe',
                'required' => true,
                'first_options' => [ 'label' => 'Nouveau Mot de passe', 'attr' => ['placeholder' => 'Merci de saisir votre nouveau mot de passe']],
                'second_options' => [ 'label' => 'Confirmez votre nouveau mot de passe', 'attr' => ['placeholder' => 'Merci de confirmer votre nouveau mot de passe']]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Modifier",
                'attr' => [
                    'class' => 'w-100 btn btn-dark'
                ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
