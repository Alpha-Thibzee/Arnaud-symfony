<?php

namespace App\Controller;

use App\Repository\CardsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('cardlist', name: 'card_list')]
    public function list( CardsRepository $repo): Response
    {
        // $filter = $this->createForm(FilterType::class);
        // $filter->handleRequest($request);
        $cards = $repo -> findAll();

        // if($filter->isSubmitted() && $filter->isValid()){
        //     $category = $filter['category']->getData();
        //     $order = ($filter["dateOrder"]->getData()? 'ASC' : 'DESC');
        //     $tag = $filter['tag']->getData();
        //     $articles = $repo->filterArticle($category, $order, $tag);
        // }

        return $this->render('/list.html.twig', [
            'cartes' => $cards,

        ]);
    }
}
