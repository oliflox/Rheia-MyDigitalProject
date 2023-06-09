<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(): Response
    {
        $searchTerm = 'Recherche';
        $orderDirection = 'asc';
        $orderBy = 'nom';

        $result = [ 
        [
            'nom' => 'École 3',
            'adresse' => 'Adresse 3',
            'poids_total_recycle' => '20'
         ],
        [
            'nom' => 'École 1',
            'adresse' => 'Adresse 1',
            'poids_total_recycle' => '15'
        ],
        [
            'nom' => 'École 2',
            'adresse' => 'Adresse 2',
            'poids_total_recycle' => '10'
        ]];
        
        return $this->render('classement/index.html.twig', [
            'controller_name' => 'ClassementController',
            'searchTerm' => $searchTerm,
        'orderDirection' => $orderDirection,
        'orderBy' => $orderBy,
        'result' => $result,
        ]);
    }
}
