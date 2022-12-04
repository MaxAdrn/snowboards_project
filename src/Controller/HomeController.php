<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/aide", name="aide")
     */
    public function aide(): Response
    {
        
        return $this->render('home/aide.html.twig');
    }
    
    /**
     * @Route("/mentions-legale", name="mentions_legales")
     */
    public function mention(): Response
    {
        
        return $this->render('home/footer/mention.html.twig');
    }

    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv(): Response
    {
        
        return $this->render('home/footer/cgv.html.twig');
    }

    /**
     * @Route("/cambres", name="cambres")
     */
    public function cambre(): Response
    {
        
        return $this->render('home/cambre.html.twig');
    }

    /**
     * @Route("/shape", name="shape")
     */
    public function shape(): Response
    {
        
        return $this->render('home/shape.html.twig');
    }

}
