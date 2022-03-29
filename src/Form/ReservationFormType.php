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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'empty_data' => null,
                'attr' => ["class" => 'startdate'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre date de début de séjour souhaitée'])
                ]
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin de séjour',
                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => null,
                'attr' => ["class" => 'enddate'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre date de fin de séjour souhaitée'])
                ]
            ])
            ->add('hotels', EntityType::class, [
                'label' => 'Hôtel',
                'class' => Hotels::class,
                'required' => true,
                'placeholder' => 'Choisir un hôtel',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.name', 'ASC');
                },
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner votre hôtel'])
                ]
            ]);
        $formModifier = function (FormInterface $form, Hotels $hotels = null) {
            $hotelRooms = null === $hotels ? [] : $hotels->getHotelRooms();

            $form->add('hotelRooms', EntityType::class, [
                'class' => HotelRooms::class,
                'placeholder' => '',
                'choices' => $hotelRooms,
                'label' => 'Suites'
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getHotelRooms());
            });

        $builder->get('hotels')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $hotel = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $hotel);
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationRooms::class,
        ]);


    }
}