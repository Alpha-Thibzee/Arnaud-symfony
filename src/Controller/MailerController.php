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
    public function index(CardsRepository $card , Cards $cards ,Request $request, TransportInterface $mailer, $id)
    {
        $card->findOneBy(['id' => $id]);
        $value = $cards->getValue()+1;
        $name = $cards->getName();
        $form = $this->createForm(MailerType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new TemplatedEmail())
                ->from($contactFormData['email'])
                ->to('alexis@carte-collection.com')
                ->subject('Nouvelle propositon d\'achat pour la carte '.$name.' d\'une valeur de '. $contactFormData['value'].'€')
                ->text("ta mere")
                ->context([
                    'mail' => $contactFormData["email"],
                    'name' => $contactFormData["name"],
                    'value' => $contactFormData["value"],
                ]);

                    try {
                        $mailer->send($message);
                        $this->addFlash('success', 'Votre proposition d\'offre pour la carte "'.$name.'" à bien été envoyé');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash('error', 'Votre proposition d\'offre pour la carte "'.$name.'" n\'a pas été envoyé');
                        return $this->redirectToRoute('homepage');
                    }


            return $this->redirectToRoute('cardlist');
        }
        
        return $this->render('mailer/index.html.twig', [
            'name' => $name,
            'value' => $value,
            'form' => $form->createView()
        ]);
    }

}
