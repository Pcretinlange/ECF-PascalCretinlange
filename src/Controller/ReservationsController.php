<?php

namespace App\Controller;

use App\Entity\ReservationRooms;
use App\Form\ReservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{
    #[Route('/reservations', name: 'app_reservations')]
    public function new(Request $request): Response
{
    $reservationRooms = new ReservationRooms();
    $form = $this->createForm(ReservationFormType::class, $reservationRooms);
        return
            $this ->render('reservations/index.html.twig', [
            'reservationForm' => $form->createView(),
        ]);
    }
}
