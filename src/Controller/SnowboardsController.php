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
        $filtre = $snow->orderByNom();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add( Request $request, ManagerRegistry $doctrine)
    {
        $snowboards = new Snowboards;
        $formSnowboards = $this->createForm(SnowboardsType::class, $snowboards);
        $formSnowboards->handleRequest($request);

        if($formSnowboards->isSubmitted() && $formSnowboards->isValid())
        {
            $snowboards->setUpdatedAt(new \DateTime());
            $em = $doctrine->getManager();
            $em->persist($snowboards);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

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
    
        /**
         * @Route("/splitboards/homme", name="_splitboards_homme")
         */
        public function splitboardsHomme( SnowboardsRepository $snow)
        {
            $filtre = $snow->findSplitboardsHomme();
    
            return $this->render('snowboards/index.html.twig', [
                'filtre' => $filtre
            ]);
        }

    /**
     * @Route("/splitboards/femme", name="_splitboards_femme")
     */
    public function splitboardsFemme( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsFemme();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/enfant", name="_splitboards_enfant")
     */
    public function splitboardsEnfant( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsEnfant();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/cambre-classique", name="_splitboards_cambre_classique")
     */
    public function splitboardsCambreClassique( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsCambreClassique();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/cambre-inverse", name="_splitboards_cambre_inverse")
     */
    public function splitboardsCambreInverse( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsCambreInverse();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }
    
    /**
     * @Route("/splitboards/cambre-plat", name="_splitboards_cambre_plat")
     */
    public function splitboardsCambrePlat( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsCambrePlat();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/cambre-w", name="_splitboards_cambre_w")
     */
    public function splitboardsCambreW( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsCambreW();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/cambre-rocker", name="_splitboards_cambre_rocker")
     */
    public function splitboardsCambreRocker( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsCambreRocker();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/debutant", name="_splitboards_debutant")
     */
    public function splitboardsDebutant( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsDebutant();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/intermediaire", name="_splitboards_intermediaire")
     */
    public function splitboardsIntermediaire( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsIntermediaire();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/confirme", name="_splitboards_confirme")
     */
    public function splitboardsConfirme( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsConfirme();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/shape-twin", name="_splitboards_shape_tw")
     */
    public function splitboardsShapeTwin( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsShapeTwin();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/shape-directionnel", name="_splitboards_shape_di")
     */
    public function splitboardsShapeDirectionnel( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsShapeDirectionnel();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }

    /**
     * @Route("/splitboards/shape-twin-directionnel", name="_splitboards_shape_tw")
     */
    public function splitboardsShapeTwinDir( SnowboardsRepository $snow)
    {
        $filtre = $snow->findSplitboardsShapeTwinDir();

        return $this->render('snowboards/index.html.twig', [
            'filtre' => $filtre
        ]);
    }
    
}