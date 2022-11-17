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
    public function index(ManagerRegistry $doctrine, SnowboardsRepository $snow)
    {
        $test = $snow->orderByNom();

        return $this->render('snowboards/index.html.twig', [
            // 'snowboards' => $snowboards,
            'test' => $test
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
    
}