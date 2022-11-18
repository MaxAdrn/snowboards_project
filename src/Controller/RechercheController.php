<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Repository\SnowboardsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche-personnalisee", name="recherche")
     */
    public function recherche(Request $request, SnowboardsRepository $snowboardsRepo)
    {
        //je crée la variable vide pour l'extraire de ma condition
        $snows = [];
        //creation du formulaire de recherche
        $rechercheForm = $this->createForm(RechercheType::class);
        $rechercheForm->handleRequest($request);

        //si formulaire soumis et valide
        if($rechercheForm->isSubmitted() && $rechercheForm->isValid()) {
            //recuperes les paramètres definit dans Snowboards Repository
            $criteres = $rechercheForm->getData();
            //on les applique à notre fonction de recherche personnalisée
            $snows = $snowboardsRepo->recherchePerso($criteres);
        }

        return $this->render('recherche/index.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'snows' => $snows
        ]);
    }
}
