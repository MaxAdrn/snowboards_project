<?php

namespace App\Controller;

use App\Entity\Snowboards;
use App\Form\SnowboardsType;
use App\Repository\SnowboardsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/snowboards", name="snowboards")
 */
class SnowboardsController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index( SnowboardsRepository $snow): Response
    {
        // je récupère tout les snowboards
        $snowboards = $snow->findAll();
        //je les envois à la vue
        return $this->render('snowboards/index.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/add", name="_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        // création nouvel objet snowboards
        $snowboards = new Snowboards;
        
        // création formulaire pour l'ajout d'un snowboard
        $formSnowboards = $this->createForm(SnowboardsType::class, $snowboards);

        // traitement des données du formulaire
        $formSnowboards->handleRequest($request);

        // s'il est soumis et valide alors
        if($formSnowboards->isSubmitted() && $formSnowboards->isValid()) {

            // alimentation automatique du champs updatedAt (nécessaire pour mettre à jour l'image du snowboard si besoin)
            $snowboards->setUpdatedAt(new \DateTime());

            // appel de l'entité manager de doctrine pour l'enregistrement
            $entityManager = $doctrine->getManager();

            // persiste l'enregistrement des données
            $entityManager->persist($snowboards);

            // on enregistre en base de données
            $entityManager->flush();

            // redirection vers la page de gestion des snowboards des admins
            return $this->redirectToRoute('admin_snowboards');
        }

        return $this->renderForm('snowboards/add.html.twig', [
            'formSnowboards' => $formSnowboards
        ]);
    }

    /**
     * @Route("/detail/{id}", name="_detail")
     */
    public function show($id, ManagerRegistry $doctrine): Response
    {
        $snowboard = $doctrine->getRepository(Snowboards::class)->find($id);

        return $this->render('snowboards/detail.html.twig', [
            'snowboard' => $snowboard,
        ]);
    }

    /**
     * @Route("/splitboards", name="_splitboards")
     */
    public function splitboards( SnowboardsRepository $snowRepo): Response
    {
        $programme = 1;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/splitboards.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/polyvalent-freeride", name="_poly_freeride")
     */
    public function polyvalentFreeride( SnowboardsRepository $snowRepo): Response
    {
        $programme = 2;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/polyfreeride.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/freeride", name="_freeride")
     */
    public function freeride( SnowboardsRepository $snowRepo): Response
    {
        $programme = 3;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/freeride.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/polyvalent-freestyle", name="_poly_freestyle")
     */
    public function polyvalentFreestyle( SnowboardsRepository $snowRepo): Response
    {
        $programme = 4;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/polyfreestyle.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/freestyle", name="_freestyle")
     */
    public function freestyle( SnowboardsRepository $snowRepo): Response
    {
        $programme = 5;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/freestyle.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/carving", name="_carving")
     */
    public function carving( SnowboardsRepository $snowRepo): Response
    {
        $programme = 6;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/carving.html.twig', [
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/poudreuse", name="_poudreuse")
     */
    public function poudreuse( SnowboardsRepository $snowRepo): Response
    {
        $programme = 7;
        $snowboards = $snowRepo->findByProgramme($programme);

        return $this->render('snowboards/programme/poudreuse.html.twig', [
            'snowboards' => $snowboards
        ]);
    }
}