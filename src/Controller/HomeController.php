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
        
        return $this->render('footer/mention.html.twig');
    }

}
