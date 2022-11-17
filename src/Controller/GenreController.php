<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/genre", name="genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function index(): Response
    {
        return $this->render('genre/index.html.twig', [
            'controller_name' => 'GenreController',
        ]);
    }

    /**
     * @Route("/genre", name="_add")
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $genre = new Genre;
        $formGenre = $this->createForm(GenreType::class, $genre);
        $formGenre->handleRequest($request);

        if($formGenre->isSubmitted() && $formGenre->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($genre);
            $em->flush();

            // $this->addFlash('annonce_succes', "Votre annonce a bien été ajoutée !");

            return $this->redirectToRoute('snowboards_add');
        }

        return $this->renderForm('genre/add.html.twig', [
            'formGenre' => $formGenre
        ]);
    }
}

