<?php

namespace App\Controller;

use App\Entity\Cambre;
use App\Form\CambreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cambre", name="cambre")
 */
class CambreController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index(): Response
    {
        return $this->render('cambre/index.html.twig', [
            'controller_name' => 'CambreController',
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $cambre = new Cambre;
        $formCambre = $this->createForm(CambreType::class, $cambre);
        $formCambre->handleRequest($request);

        if($formCambre->isSubmitted() && $formCambre->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($cambre);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('cambre/add.html.twig', [
            'formCambre' => $formCambre
        ]);
    }
}
