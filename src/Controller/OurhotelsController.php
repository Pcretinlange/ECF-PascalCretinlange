<?php

namespace App\Controller;

use App\Entity\Hotels;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OurhotelsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/ourhotels', name: 'app_ourhotels')]
    public function index(): Response
    {
        $hotels = $this->entityManager->getRepository(Hotels::class)->findAll();
        return $this->render('ourhotels/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }
}
