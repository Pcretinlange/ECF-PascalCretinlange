<?php

namespace App\Form;

use App\Entity\HotelRooms;
use App\Entity\Hotels;
use App\Entity\ReservationRooms;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'label' => 'Date de début de séjour',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ["class" =>'startdate'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre date de début de séjour souhaitée'])
                ]
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin de séjour',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ["class" =>'enddate'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre date de fin de séjour souhaitée'])
                ]
            ])
            ->add('hotels', EntityType::class, [
                'label' => 'Hôtel',
                'class' => Hotels::class,
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.name', 'ASC');
                },
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre hôtel'])
                ]
            ])

              ->add('hotel_rooms', EntityType::class, [
                    'label' => 'Suite associée',
                    'class' => HotelRooms::class,
                    'required' => true,
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez sélectionner votre Suite'])
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationRooms::class,
        ]);
    }
}
