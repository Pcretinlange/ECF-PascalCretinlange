<?php

namespace App\Controller;

use App\Entity\HotelRooms;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuitesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/suites/{id}', name: 'app_suites')]
    public function index($id): Response
    {
        $suites = $this->entityManager->getRepository(HotelRooms::class)->findBy(array('hotels' => $id));
        $hoteltitle = $this->entityManager->getRepository(HotelRooms::class)->findOneBy(array('hotels' => $id));
        return $this->render('suites/index.html.twig', [
            'suites' => $suites,
            'hoteltitle' => $hoteltitle
        ]);



    }
}
