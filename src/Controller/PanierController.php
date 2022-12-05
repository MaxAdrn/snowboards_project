<?php

namespace App\Controller;

use App\Entity\Snowboards;
use App\Repository\SnowboardsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/panier", name="panier")
     */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index(SessionInterface $session, SnowboardsRepository $snowboardsRepository): Response
    {
        // Je récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        // Variable tableau
        $panierData = [];
        
        foreach($panier as $id => $quantite)
        {
            // J'enrichis le tableau avec l'objet (qui contient toutes les informations du produit) + la quantité
            $panierData[] = [
                // Je définis la clé snowboards qui contiendra le snowboard et la clé quantite qui contient la quantité
                "snowboards" => $snowboardsRepository->find($id),
                "quantite" => $quantite
            ];
        }

        // Je calcule le total du panier
        $total = 0;
        foreach($panierData as $id => $value)
        {
            // Je récupère le prix pour chaque du snowboard que je multiplie par sa quantité
            $total += $value['snowboards']->getPrix() * $value['quantite'];
        }

        return $this->render('panier/index.html.twig', [
            "panierData" => $panierData,
            "total" => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="_add")
     */
    public function cartAdd($id, Snowboards $snowboards, SessionInterface $session): Response
    {
        // Je récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        $stock = $snowboards->getStock();
        // Je vérifie si l'élément de session d'id $id existe, si oui j'incrémente de 1 la quantité
        // et je contrôle que la quantité ne puisse pas dépasser le stock
        if(!empty($panier[$id]) && ($stock > $panier[$id])) 
        {
            $panier[$id]++;
        }
        else
        {
            //Si non j'initialise la quantité a 1
            $panier[$id] = 1;
        }
        // Je remplace la variable de session panier par le nouveau tableau $panier
        $session->set('panier', $panier);

        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("/panier/retirer/{id}", name="_retirer")
     */
    public function retirer($id, SessionInterface $session): Response
    {
        // Je récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        // Je vérifie si l'élément de session d'id $id existe, si oui on décrémente de 1 la quantité
        if(!empty($panier[$id])) {
            if($panier[$id] > 1) {
                $panier[$id]--;
            } 
            // si la quantité est à zéro, je supprime de la session celui dont on a passé l'id
            else {
                unset($panier[$id]);
            }
        }
        // Je réaffecte le nouveau panier à la session
        $session->set('panier', $panier);
        // redirection vers le panier
        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("/panier/supprimer/{id}", name="_supprimer")
     */
    public function supprimer($id, SessionInterface $session): Response
    {
        // Je récupere la session 'panier' si elle existe, sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);        
        // Je supprime de la session de celui dont on a passé l'id
        if(!empty($panier[$id]))
        {
            // unset pour dépiler de la session
            unset($panier[$id]);
        }
        // Je réaffecte le nouveau panier à la session
        $session->set('panier', $panier);
        // Je redirige vers le panier
        return $this->redirectToRoute('panier_index');
    }
}
