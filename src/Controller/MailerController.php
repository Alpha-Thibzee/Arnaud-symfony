<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Form\MailerType;
use Symfony\Component\Mime\Email;
use App\Repository\CardsRepository;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer/{id}', name: 'sendmail')]
    public function mailer(TransportInterface $mailer,Cards $card, CardsRepository $repo, $id, Request $request): Response
    {

        $repo->findOneBy(['id' => $id]);
        $value = $card->getValue()+10;
        $name = $card->getName(); 
        $form = $this->createForm(MailerType::class); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()) { 

        $contactFormData = $form->getData();
        
        $email = (new TemplatedEmail())
            ->from($contactFormData['email'])
            ->to('alexis@admin.com')
            ->subject('Proposition d\'achat pour la carte '.$name.' indéxée actuellement sur le site à '.$value.'')
            // ->text('Sending emails is fun again!')
            ->htmlTemplate('mailer/index.html.twig')
            ->context([
                'email' => $contactFormData["email"],
                'name' => $contactFormData["nom"], 
                'value' => $contactFormData["value"], 
                 
                // 'newvalue' =>$newValue,
            ]);
            try { 
                $mailer->send($email); 
                $this->addFlash('success', 'Votre proposition d\'offre à bien été envoyé'); 
                } catch (TransportExceptionInterface $e) { 
                $this->addFlash('error', 'Votre proposition d\'offre a échoué'); 
                return $this->redirectToRoute('homepage'); 
                } 
                return $this->redirectToRoute('homepage'); } 
                return $this->render('mailer/index.html.twig', [ 
                'name' => $name, 
                'value' => $value, 
                'form' => $form->createView() ]); }

        // $mailer->send($email);
        // $this->addFlash('success','Votre offre a été envoyée avec succès');

    // dd( $mailer->send($email)->getDebug());

    
    }

