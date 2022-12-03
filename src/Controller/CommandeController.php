<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Snowboards;
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
     * @Route("/", name="_index")
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/new", name="_new")
     */
    public function new(Request $request, ManagerRegistry $doctrine, SessionInterface $session, SnowboardsRepository $snowboards): Response
    {
        $panier = $session->get('panier', []);
        
        $commande = new Commande();
        $formCommande = $this->createForm(CommandeType::class, $commande);
        $formCommande->handleRequest($request);
             // pour chaque id il faut récupérer le produit correspondant et le set dans detail commande 
             
             foreach($panier as $key => $value) {
                $productToAdd[] = $snowboards->find($key);
                $commande->setDetailCommande($productToAdd);
            }
            $panier = $session->get('panier', []);
            $panierData = [];
            $total = 0;
            foreach($panier as $id => $quantite)
            {
                $snow = $snowboards->find($id);
                $panierData[] = [
                    "snowboards" => $snow,
                    "quantite" => $quantite
                ];
                $total += $snow->getPrix() * $quantite;
            }


            $commande->setMontant($total);
            
            $detailCommande = $commande->getDetailCommande();
            // dd($detailCommande);
            if ($formCommande->isSubmitted() && $formCommande->isValid()) {

            //gestion des stocks apres commande

            foreach($panierData as $detail){
                $snowTofind = $snowboards->find($detail['snowboards']);
                $qteToretire = $detail['quantite'];
                $snowTofind->setStock($snowTofind->getStock()-$qteToretire);
            }

            $commande->setUser($this->getUser());
            $commande->setCreatedAt(new DateTime());

            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }
        //************************************************************************************ */

                #On récupere la session 'panier' si elle existe - sinon elle est créée avec un tableau vide

        //************************************************************************************ */
        if($this->getUser()) {
            return $this->renderForm('commande/new.html.twig', [
                'formCommande' => $formCommande,
                "panierData" => $panierData, 
                "total" => $total,
                "montant" => $commande->getMontant()
            ]);
        } else {

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

    /**
     * @Route("/edit/{id}", name="commande_edit")
     */
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete")
     */
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
