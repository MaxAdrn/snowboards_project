<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marque", name="marque")
 */
class MarqueController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index()
    {
        return $this->render('marque/index.html.twig', [
            'controller_name' => 'MarqueController',
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $marque = new Marque;
        $formMarque = $this->createForm(MarqueType::class, $marque);
        $formMarque->handleRequest($request);

        if($formMarque->isSubmitted() && $formMarque->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($marque);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('marque/add.html.twig', [
            'formMarque' => $formMarque
        ]);
    }
}
