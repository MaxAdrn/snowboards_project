<?php

namespace App\Controller;

use App\Entity\Snowboards;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/snowboards", name="admin_snowboards")
     */
    public function adminSnowboards(ManagerRegistry $doctrine)
    {
        $snowboards = $doctrine->getRepository(Snowboards::class)->findAll();

        return $this->render('admin/snowboards.html.twig', [
            'snowboards' => $snowboards,
        ]);
    }
}
