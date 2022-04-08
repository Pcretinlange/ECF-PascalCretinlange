<?php

namespace App\Controller;

use App\Entity\ReservationRooms;
use App\Entity\Users;
use App\Form\ReservationFormType;
use App\Repository\ReservationRoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{
    public RequestStack $requestStack;
    public EntityManagerInterface $entityManager;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager )
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    #[Route('/reservations', name: 'app_reservations')]
    public function new(Request $request, ReservationRoomsRepository $reservationRoomsRepository): Response
    {

        if ($_GET == true) {
            $id_hotel = $_GET['hotel'];
            $id_suite = $_GET['suite'];
            $this->requestStack->getSession()->set('hotel', $id_hotel);
            $this->requestStack->getSession()->set('suite', $id_suite);
        }

        $reservationRooms = new ReservationRooms();
        $form = $this->createForm(ReservationFormType::class, $reservationRooms);
        $form->handleRequest($request);
        $data = null;
        $dt = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $req = $reservationRoomsRepository->findReservation(
                $form->get('hotels')->getData(),
                $form->get('hotelRooms')->getData(),
                $form->get('start_date')->getData(),
                $form->get('end_date')->getData()
            );
            if (empty($req)) {
                $data = $form->getData();
                $this->requestStack->getSession()->set('form_reservation', $data);

            }
            if (!empty($req)) {
                $dt = true;
            }
            /**@var Users $users */
            $users = $this->getUser();
            $reservationRooms->setUsers($users);
        }
        return
            $this->render('reservations/index.html.twig', [
                'reservationForm' => $form->createView(),
                'data' => $data,
                'dt' => $dt
            ]);
    }

    #[Route('/confirmation', name: 'app_confirmation')]
    public function confirm(): Response
    {
        if ($this->requestStack->getSession()->get('form_reservation')) {
            $form_reservation = new ReservationRooms();
            $data = $this->requestStack->getSession()->get('form_reservation');
            $form_reservation->setHotels($data->getHotels());
            $form_reservation->sethotelRooms($data->getHotelRooms());
            $form_reservation->setStartDate($data->getStartDate());
            $form_reservation->setEndDate($data->getEndDate());
            $form_reservation->setUsers($data->getUsers());
            $totalPrice = ($data->getStartDate()->diff($data->getEndDate())->format("%r%a"))*$data->getHotelRooms()->getPrice();
            $form_reservation->setTotalPrice($totalPrice);

            $this->entityManager->merge($form_reservation);
            $this->entityManager->flush();
            $this->requestStack->getSession()->remove('form_reservation');
    }    else {
            return $this->redirectToRoute('app_reservations');


        }

            return
                $this->render('reservations/confirmation.html.twig', [
                    'data' => $data,
                ]);
        }

}
