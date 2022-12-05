<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\SnowboardsRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande", name="commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/new", name="_new")
     */
    public function new(Request $request, ManagerRegistry $doctrine, SessionInterface $session, SnowboardsRepository $snowboardsRepository): Response
    {
        // Même méthode que l'index panier
        $panier = $session->get('panier', []);
        $panierData = [];
        foreach($panier as $id => $quantite)
        {
            $panierData[] = [
                "snowboards" => $snowboardsRepository->find($id),
                "quantite" => $quantite
            ];
        }

        $total = 0;
        foreach($panierData as $id => $value)
        {
            // Je récupère le prix pour chaque du snowboard et le multiplie par sa quantité
            $total += $value['snowboards']->getPrix() * $value['quantite'];
        }

        $commande = new Commande();
        $formCommande = $this->createForm(CommandeType::class, $commande);
        $formCommande->handleRequest($request);
        // je set le montant avec le total
        $commande->setMontant($total);
        $commande->setUser($this->getUser());
        $commande->setCreatedAt(new DateTime());
        // je set les produits
        foreach($panier as $id) {
            // pour chaque id je récupère le produit correspondant
            $ajouterSnowboard[] = $snowboardsRepository->find($id);
            // et je le set dans detailCommande
            $commande->setDetailCommande($ajouterSnowboard);
        }
        
        if ($formCommande->isSubmitted() && $formCommande->isValid())
        {
            // gestion des stocks apres commande
            foreach($panierData as $value){
                $snowboard = $snowboardsRepository->find($value['snowboards']->getId());
                $quantiteARetirer = $value['quantite'];
                $snowboard->setStock($snowboard->getStock()-$quantiteARetirer);
            }

            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('checkout', [], Response::HTTP_SEE_OTHER);
        }

        if($this->getUser())
        {
            return $this->renderForm('commande/new.html.twig', [
                'formCommande' => $formCommande,
                "panierData" => $panierData, 
                "total" => $total
            ]);
        }
        else
        {
            $this->addFlash('creation_panier', "Si vous n'avez pas de compte, vous pouvez le créer en cliquant sur le bouton \"Créer un compte\" ci-dessous");
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/show/{id}", name="_show")
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }
}
