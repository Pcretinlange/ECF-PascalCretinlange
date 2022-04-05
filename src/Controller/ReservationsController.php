<?php

namespace App\Controller;

use App\Entity\ReservationRooms;
use App\Entity\Users;
use App\Form\ReservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/reservations', name: 'app_reservations')]
    public function new(Request $request): Response
{

    if($_GET == true){
        $id_hotel = $_GET['hotel'];
        $id_suite = $_GET['suite'];
        $this->requestStack->getSession()->set('hotel', $id_hotel);
        $this->requestStack->getSession()->set('suite', $id_suite);
    }

    $reservationRooms = new ReservationRooms();
    $form = $this->createForm(ReservationFormType::class, $reservationRooms);
    $form->handleRequest($request);
    $data = null;
      if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        /**@var Users $users */
        $users = $this->getUser();
        $reservationRooms->setUsers($users);
    }
        return
            $this ->render('reservations/index.html.twig', [
            'reservationForm' => $form->createView(),
            'data' => $data
        ]);
    }
}
