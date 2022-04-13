<?php

namespace App\Controller;

use App\Entity\ReservationRooms;
use App\Entity\Users;
use App\Form\ModificationPassType;
use App\Repository\ReservationRoomsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct (EntityManagerInterface $entityManager)
{
    $this->entityManager = $entityManager;
}
    #[Route('/account', name: 'app_account')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, ReservationRoomsRepository $reservationRoomsRepository):Response
    {
        /**
         * @var Users $users
         */
        $users = $this->getUser();
        $form = $this->createForm(ModificationPassType::class);
        $resa = $reservationRoomsRepository->findBy(array('users' => $this->getUser()), array('start_date'=>'ASC'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $form->get('password')->getData();
            if ($userPasswordHasher->isPasswordValid($users, $password)){
                $newPassword = $form->get('passwordmodification')->getData();
                $hashPassword = $userPasswordHasher->hashPassword($users, $newPassword);
                $newPassword = $users->setPassword($hashPassword);
                $this->entityManager->persist($newPassword);
                $this->entityManager->flush();
                $this->addFlash('successPassword', 'Votre nouveau mot de passe a bien été enregistré');
            }
            else{
                $this->addFlash('errorPassword', 'Le mot de passe actuel est incorrect');
            }
        }

            return $this->render('account/index.html.twig', [
            'modificationPass' => $form->createView(),
                'resa' => $resa
        ]);
    }

    #[Route('/account/erase/{id}', name: 'reservation_erase', methods: ['POST','DELETE'])]
    public function delete(Request $request, ReservationRooms $reservationRooms):Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationRooms->getId(), $request->request->get('_token'))){
            $this->entityManager->remove($reservationRooms);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_account');
    }
}

