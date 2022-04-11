<?php

namespace App\Form;

use App\Entity\HotelRooms;
use App\Entity\Hotels;
use App\Entity\ReservationRooms;
use App\Repository\HotelRoomsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'label' => 'Date de début de séjour',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'empty_data' => null,
                'attr' => ["class" => 'startdate', 'autocomplete' => 'off'],
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin de séjour',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'empty_data' => null,
                'attr' => ["class" => 'enddate', 'autocomplete' => 'off'],
            ])
            ->add('hotels', EntityType::class, [
                'label' => 'Hôtel',
                'class' => Hotels::class,
                'required' => true,
                'placeholder' => 'Choisir un hôtel',
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.name', 'ASC');
                },
                'choice_attr' => function($hotelId) {
                    $render = [];
                    if ($hotelId->getId() == $this->requestStack->getSession()->get('hotel')){
                        $render['selected'] = "selected";
                    }
                    return $render;
                }
            ]);
        $formModifier = function (FormInterface $form, Hotels $hotels = null) {
            $hotelRooms = null === $hotels ? [] : $hotels->getId();
            $hotelsId = $this->requestStack->getSession()->get('hotel');

            $form->add('hotelRooms', EntityType::class, [
                'class' => HotelRooms::class,
                'query_builder' => function (HotelRoomsRepository $hotelRoomsRepository) use ($hotelRooms, $hotelsId) {
                    if ($this->requestStack->getSession()->get('suite')) {
                       $qb = $hotelRoomsRepository->createQueryBuilder('s')
                            ->andWhere('s.hotels = :hotel')
                           ->setParameter("hotel", $hotelsId );
                     }
                    else {
                        $qb = $hotelRoomsRepository->createQueryBuilder('s')
                            ->andWhere('s.hotels = :hotel')
                            ->setParameter("hotel", $hotelRooms );
                    }
                        return $qb;
                 },
                'label' => 'Suites',
                'choice_attr' => function($hotelId) {
                    $render = [];
                    if ($hotelId->getId() == $this->requestStack->getSession()->get('suite')){
                        $render['selected'] = "selected";
                    }
                    return $render;
                }
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
                $this->requestStack->getSession()->set('suite', '');
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