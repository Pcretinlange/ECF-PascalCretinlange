<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailerInterface): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $email = (new Email())
                    ->from(new Address($form->get('email')->getData(), $form->get('firstname')->getData()." ".$form->get('lastname')->getData()))
                    ->to('pascal.cretinlange@gmail.com')
                    ->subject($form->get('subject')->getData())
                    ->priority(Email::PRIORITY_HIGH)
                    ->text($form->get('message')->getData());
                $mailerInterface->send($email);

                $this->addFlash('confirm', 'Votre message a bien été envoyé, merci !');

        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
