<?php

namespace App\Controller;

use App\Entity\Snowboards;
use App\Form\SnowboardsType;
use App\Repository\SnowboardsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/snowboards", name="snowboards")
 */
class SnowboardsController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index( SnowboardsRepository $snow)
    {
        //je récupère tout les snowboards filtrer par nom pour eviter les doublons
        $filtre = $snow->orderByNom();
        //je les envois à la vue
        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add( Request $request, ManagerRegistry $doctrine)
    {
        // création nouvel objet snowboards
        $snowboards = new Snowboards;
        
        // création formulaire
        $formSnowboards = $this->createForm(SnowboardsType::class, $snowboards);

        // traitement des données du formulaire
        $formSnowboards->handleRequest($request);

        // s'il est soumis et valide alors
        if($formSnowboards->isSubmitted() && $formSnowboards->isValid()) {

            // alimentation automatique du champs updatedAt (nécessaire si besoin pour mettre à jour l'image du snowboard)
            $snowboards->setUpdatedAt(new \DateTime());

            // appel de l'entité manager de doctrine pour l'enregistrement
            $em = $doctrine->getManager();

            // persiste l'enregistrement en base de donnée
            $em->persist($snowboards);

            // on enregistre en base de donnée
            $em->flush();

            // $this->addFlash('snowboard_succes', "Votre snowboard a bien été ajoutée !");

            // redirection vers la page de gestion des snowboards des admins
            return $this->redirectToRoute('snowboards_detail', ["id" => $snowboards->getId()]);
        }

        return $this->renderForm('snowboards/add.html.twig', [
            'formSnowboards' => $formSnowboards
        ]);
    }

    /**
     * @Route("/show/{slug}", name="_showbyname")
     */
    public function showByName($slug, ManagerRegistry $doctrine)
    {
        // dd($slug);
        $snowboards = $doctrine->getRepository(Snowboards::class)->findBy(['nom' => $slug]);
        // dd($snowboards);

            return $this->renderForm('snowboards/showbyname.html.twig', [
                'snowboards' => $snowboards,
            ]);
    }  

    /**
     * @Route("/detail/{id}", name="_detail")
     */
    public function show($id, ManagerRegistry $doctrine)
    {
        $snowboard = $doctrine->getRepository(Snowboards::class)->find($id);

        if(!$snowboard) {
            throw new \Exception("Aucun snowboard n'a été trouvé !");
        }
        else {

            return $this->renderForm('snowboards/detail.html.twig', [
                'snowboard' => $snowboard,
            ]);
        }
    }

    /**
     * @Route("/splitboards", name="_splitboards")
     */
    public function splitboards( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboards();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }
}