<?php

namespace App\Controller;

use App\Entity\Snowboards;
use Doctrine\Persistence\ManagerRegistry;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement", name="app_paiement")
     */
    public function index(): Response
    {
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'paiementController',
        ]);
    }

    /**
     * @Route("/paiement/checkout", name="checkout")
     */
    public function checkout($stripeSK, SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        // On met en paramètre la clé API (défini dans le .env et configuré dans le ficher services.yaml)
        Stripe::setApiKey($stripeSK);

        // On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        // Variable tableau
        $panierData = [];

        foreach($panier as $id => $quantity)
        {
            // On enrichi le tableau avec l'objet (qui contient toutes les informations du produit) + la quantité
            $panierData[] = [
                "product" => $doctrine->getRepository(Snowboards::class)->find($id),
                "quantity" => $quantity
            ];
        }

        // On construit le line_items pour envoyer ce format a Stripe, afin qu'il puisse afficher correctement dans le module de paiement Stripe.
        foreach($panierData as $id => $value)
        {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $value['product']->getNom(),
                    ],
                    'unit_amount' => $value['product']->getPrix()*100, //Attention: bien mettre le format sans virgule et collé avec les centimes => dans notre cas, le prix est un entier donc ici on multiplie simplement par 100 (exemple 20€ donne 2000)
                    ],
                    'quantity' => $value['quantity'],                
                ];
        }

        $session = Session::create([
            'line_items' => [
                $line_items // On place le tableau construit juste au-dessus, pour les line_items.
            ],
              'mode' => 'payment',
              'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
              'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),            
        ]);
        
        return $this->redirect($session->url, 303);
    }

    /**
     * @Route("/paiement/success", name="success_url")
     */
    public function successUrl(): Response
    {
        // Après le paiement success : libre a vous de vider les sessions et donc le panier.

        return $this->render('paiement/success.html.twig');
    }

    /**
     * @Route("/paiement/cancel", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('paiement/cancel.html.twig');
    }
}
