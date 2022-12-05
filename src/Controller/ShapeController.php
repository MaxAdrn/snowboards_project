<?php

namespace App\Controller;

use App\Entity\Shape;
use App\Form\ShapeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shape", name="shape")
 */
class ShapeController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index(): Response
    {
        return $this->render('shape/index.html.twig', [
            'controller_name' => 'ShapeController',
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $shape = new Shape;
        $formShape = $this->createForm(ShapeType::class, $shape);
        $formShape->handleRequest($request);

        if($formShape->isSubmitted() && $formShape->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($shape);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('shape/add.html.twig', [
            'formShape' => $formShape
        ]);
    }
}

