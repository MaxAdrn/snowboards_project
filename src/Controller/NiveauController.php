<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/niveau", name="niveau")
 */
class NiveauController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index(): Response
    {
        return $this->render('niveau/index.html.twig', [
            'controller_name' => 'NiveauController',
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $niveau = new Niveau;
        $formNiveau = $this->createForm(NiveauType::class, $niveau);
        $formNiveau->handleRequest($request);

        if($formNiveau->isSubmitted() && $formNiveau->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($niveau);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('niveau/add.html.twig', [
            'formNiveau' => $formNiveau
        ]);
    }
}
