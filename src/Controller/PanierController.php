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
        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        #Variable tableau
        $panierData = [];
        $total = 0;

        

        foreach($panier as $id => $quantite)
        {
            $snowboards = $snowboardsRepository->find($id);
            $panierData[] = [
                "snowboards" => $snowboards,
                "quantite" => $quantite
            ];
            $total += $snowboards->getPrix() * $quantite;
        }
        // dd($total);
        // foreach($panierData as $id => $value)
        // {
        //     $total += $value['snowboards']->getPrix() * $value['quantite'];
        // }
        

        #On envoie a la vue le panier enrichi avec les informations + le total du panier
        if($this->getUser()) {
            return $this->render('cart/index.html.twig', compact("panierData", "total"));
        }
        else {
            return $this->redirectToRoute('register');
            
        }

    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function cartAdd( Snowboards $snowboards, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $id = $snowboards->getId();
        $stock = $snowboards->getStock();
         
            if(!empty($panier[$id])) 
            {
                $panier[$id]++;
            }
            else
            {
                $panier[$id] = 1;
            }
        
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/editQty/{id}", name="cart_editQty" )
     */    
    public function editquantity(SessionInterface $session, Snowboards $snowboards){

        $panier = $session->get('panier', []);
        $id = $snowboards->getId();
        $stock = $snowboards->getStock();

        while($stock > $panier[$id]){

            if(!empty($panier[$id])) 
            {
                $panier[$id]++;
            }
            else
            {
                $panier[$id] = 1;
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");

    }

    #[Route("panier/remove/{id}", name: "cart_remove")]
    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function cartRemove(Snowboards $snowboards, SessionInterface $session)
    {
        #ETAPE 1 : on récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        $id = $snowboards->getId();

        #ETAPE 2 : On vérifie si l'élément de session d'id $id existe, si oui on incrémente de 1 la quantité
        if(!empty($panier[$id])) {
            if($panier[$id] > 1) {
                $panier[$id]--;
            } 
            else {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/delete/{id}", name="cart_delete")
     */
    public function delete(Snowboards $snowboards, SessionInterface $session)
    {
        #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide
        $panier = $session->get('panier', []);
        $id = $snowboards->getId();
        
        #On supprime de la session celui dont on a passé l'id
        if(!empty($panier[$id]))
        {
            unset($panier[$id]); //unset pour dépiler de la session
        }

        #On réaffecte le nouveau panier à la session
        $session->set('panier', $panier);

        #On redirige vers le panier
        return $this->redirectToRoute('cart_index');
    }
}
