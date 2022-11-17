<?php

namespace App\Controller;

use App\Entity\Snowinsert;
use App\Form\SnowinsertType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/snowinsert", name="snowinsert")
 */
class SnowinsertController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index(): Response
    {
        return $this->render('snowinsert/index.html.twig', [
            'controller_name' => 'SnowinsertController',
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $snowinsert = new Snowinsert;
        $formSnowinsert = $this->createForm(SnowinsertType::class, $snowinsert);
        $formSnowinsert->handleRequest($request);

        if($formSnowinsert->isSubmitted() && $formSnowinsert->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($snowinsert);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('snowinsert/add.html.twig', [
            'formSnowinsert' => $formSnowinsert
        ]);
    }
}