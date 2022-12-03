<?php

namespace App\Controller;

use App\Entity\Snowboards;
use App\Repository\SnowboardsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, SnowboardsRepository $snowboardsRepository)
    {
        // On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        // Variable tableau
        $panierData = [];
        
        foreach($panier as $id => $quantite)
        {
            // On enrichi le tableau avec l'objet (qui contient toutes les informations du produit) + la quantité
            $panierData[] = [
                // on définit la clé snowboards qui contiendra le snowboard et la clé quantite qui contient la quantité
                "snowboards" => $snowboardsRepository->find($id),
                "quantite" => $quantite
            ];
            // dd($panierData);
        }

        // on calcule le total du panier
        $total = 0;
        foreach($panierData as $id => $value)
        {
            // on récupère le prix pour chaque du snowboard qu'on multiplie par sa quantité
            $total += $value['snowboards']->getPrix() * $value['quantite'];
        }

        // on calcule le total des quantités
        $quantiteTotal = 0;
        foreach($panierData as $id => $value)
        {
            // on récupère la quantite pour chaque snowboards qu'on additionne avec la quantité total
            $quantiteTotal += $value['quantite'];
        }

        // Si c'est un utilisateur connecté, on envoie à la vue le panier enrichi avec les informations + le total du panier
        // if($this->getUser()) {
            return $this->render('cart/index.html.twig', [
                "items" => $panierData,
                "total" => $total,
                "quantiteTotal" => $quantiteTotal
            ]);
        // }
        //sinon on le redirige vers la page de connexion
        // else {
        //     $this->addFlash('creation_panier', "Vous devez vous connecter pour créer votre panier. Si vous n'avez pas de compte, vous pouvez le créer en cliquant sur le bouton \"Créer un compte\" ci-dessous");

        //     return $this->redirectToRoute('app_login');
        // }
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function cartAdd($id, Snowboards $snowboards, SessionInterface $session)
    {
        // On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        // $id = $snowboards->getId();
        $stock = $snowboards->getStock();

        // On vérifie si l'élément de session d'id $id existe, si oui on incrémente de 1 la quantité
        // et on contrôle que la quantité ne puisse pas dépasser le stock
        if(!empty($panier[$id]) && ($stock > $panier[$id])) 
        {
            // dd($panier);
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1; //Si non on initialise la quantité a 1
        }
        // On remplace la variable de session panier par le nouveau tableau $panier
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function cartRemove($id, Snowboards $snowboards, SessionInterface $session)
    {
        // on récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);

        // on vérifie si l'élément de session d'id $id existe, si oui on décrémente de 1 la quantité
        if(!empty($panier[$id])) {
            if($panier[$id] > 1) {
                $panier[$id]--;
            } 
            // si la quantité est à zéro, on supprime la session de celui dont on a passé l'id
            else {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        // redirection vers le panier
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/delete/{id}", name="cart_delete")
     */
    public function delete($id, Snowboards $snowboards, SessionInterface $session)
    {
        // On récupere la session 'panier' si elle existe, sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        $id = $snowboards->getId();
        
        // On supprime de la session de celui dont on a passé l'id
        if(!empty($panier[$id]))
        {
            // unset pour dépiler de la session
            unset($panier[$id]);
        }

        // On réaffecte le nouveau panier à la session
        $session->set('panier', $panier);

        // On redirige vers le panier
        return $this->redirectToRoute('cart_index');
    }
    // /**
    //  * @Route("/panier", name="cart_index")
    //  */
    // public function index(SessionInterface $session, SnowboardsRepository $snowboardsRepository)
    // {
    //     // On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
    //     $panier = $session->get('panier', []);
    //     dd($panier);
    //     #Variable tableau
    //     $panierData = [];
    //     $total = 0;

    //     foreach($panier as $id => $quantite)
    //     {
    //         $snowboards = $snowboardsRepository->find($id);
    //         $panierData[] = [
    //             "snowboards" => $snowboards,
    //             "quantite" => $quantite
    //         ];
    //         $total += $snowboards->getPrix() * $quantite;
    //     }

    //     #On envoie a la vue le panier enrichi avec les informations + le total du panier
    //     if($this->getUser()) {
    //         return $this->render('cart/index.html.twig', compact("panierData", "total"));
    //     }
    //     else {
    //         return $this->redirectToRoute('register');
            
    //     }
    // }

    // /**
    //  * @Route("/panier/add/{id}", name="cart_add")
    //  */
    // public function cartAdd( Snowboards $snowboards, SessionInterface $session)
    // {
    //     $panier = $session->get('panier', []);
    //     $id = $snowboards->getId();
    //     $stock = $snowboards->getStock();

    //     if(!empty($panier[$id]) && ($stock > $panier[$id])) 
    //     {
    //         // dd($panier);
    //         $panier[$id]++;
    //     }
    //     else
    //     {
    //         $panier[$id] = 1;
    //     }
        
    //     $session->set('panier', $panier);

    //     return $this->redirectToRoute("cart_index");
    // }


    // // #[Route("panier/remove/{id}", name: "cart_remove")]
    // /**
    //  * @Route("/panier/remove/{id}", name="cart_remove")
    //  */
    // public function cartRemove(Snowboards $snowboards, SessionInterface $session)
    // {
    //     #ETAPE 1 : on récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
    //     $panier = $session->get('panier', []);
    //     $id = $snowboards->getId();

    //     #ETAPE 2 : On vérifie si l'élément de session d'id $id existe, si oui on incrémente de 1 la quantité
    //     if(!empty($panier[$id])) {
    //         if($panier[$id] > 1) {
    //             $panier[$id]--;
    //         } 
    //         else {
    //             unset($panier[$id]);
    //         }
    //     }

    //     $session->set('panier', $panier);

    //     return $this->redirectToRoute("cart_index");
    // }

    // /**
    //  * @Route("/panier/delete/{id}", name="cart_delete")
    //  */
    // public function delete(Snowboards $snowboards, SessionInterface $session)
    // {
    //     #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
    //     $panier = $session->get('panier', []);
    //     $id = $snowboards->getId();
        
    //     #On supprime de la session celui dont on a passé l'id
    //     if(!empty($panier[$id]))
    //     {
    //         unset($panier[$id]); //unset pour dépiler de la session
    //     }

    //     #On réaffecte le nouveau panier à la session
    //     $session->set('panier', $panier);

    //     #On redirige vers le panier
    //     return $this->redirectToRoute('cart_index');
    // }
}
