<?php

namespace App\Controller;

use Exception;
use App\Entity\Cards;
use App\Form\CardType;
use App\Service\Upload;
use App\Form\FilterType;
use App\Repository\CardsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    

    #[Route('/card-list', name: 'cardlist')]
    public function list( CardsRepository $repo, Request $request): Response
    {
        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);
        $cards = $repo -> findAll();

         if($filter->isSubmitted() && $filter->isValid()){
       
           $order = ($filter["prix"]->getData()? 'ASC' : 'DESC');
        
            $cards = $repo->filterCards($order);
        }

        return $this->render('card/list.html.twig', [
            'cards' => $cards,
            'filter' => $filter->createView()

        ]);
    }
    #[Route("/card/{id}", name: "card_show")]
    public function show(CardsRepository $repo, $id): Response
    {
        
        $card = $repo -> findOneBy(['id' => $id]);

        return $this->render('card/show.html.twig', [
            'card' => $card
        ]);
    }

    #[Route("/admin/delete-card/{id}", name: "card_delete")]
    public function delete(Cards $card, EntityManagerInterface $em) : Response
    {
        $em->remove($card);
        try{
            $em->flush();
            $this->addFlash('success', "Carte supprimée avec succès");

        }catch(Exception $e){
            
            $this->addFlash('danger', "Echec de la suppression de la carte");
        }
        
        return $this->redirectToRoute('cardlist');
    }

    #[Route("/admin/add-card", name: "card_add")]
    public function new(Upload $fileUploader, EntityManagerInterface $em, Request $request): Response
    {
        
        $card = new Cards();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($card->getImage() === null){
                $card->setImage('1.png');
            }else{
                $avatarFile = $form->get('image')->getData();
                $avatarFileName = $fileUploader->upload($avatarFile);
                $card->setImage($avatarFileName);
            }
           $card ->setName($form->getData() -> getName());
           
           $em ->persist($card);

           try
           {
                $em -> flush($card);
                $this->addFlash('success', 'Carte ajoutée avec succès');
           }catch(Exception $e)
           {
            $this->addFlash('danger', 'Echec de la création de la carte');
                return $this->redirectToRoute('card_add');
           }
           
        }

        return $this->render('card/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/admin/edit-card/{id}", name: "card_edit")]
    public function edit(Upload $fileUploader,Cards $card, Request $request, EntityManagerInterface $em) : Response
    {
       $oldAvatar = $card->getImage();
       $form = $this->createForm(CardType::class, $card);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid()){
        $avatarFile = $form->get('image')->getData();
        if($avatarFile){
            
            if($avatarFile !== $avatarFile){
                $fileUploader->fileDelete($oldAvatar);
            }
           $avatarFileName = $fileUploader->upload($avatarFile);
            $card->setImage($avatarFileName);
        }else{
            $avatarFile = $form->get('image')->getData();
            $avatarFileName = $fileUploader->upload($avatarFile);
            $card->setImage($avatarFileName);
        }
        $em -> flush();
        $this->addFlash('success', 'Carte modifiée avec succès');
            return $this->redirectToRoute('cardlist');
       }
       $this->addFlash('danger', 'Echec de la modification de la carte');
        return $this->render('card/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
