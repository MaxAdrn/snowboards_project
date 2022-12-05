<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Snowboards;
use App\Entity\User;
use App\Form\SnowboardsType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin", name="admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/index", name="_index")
     */
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
        ]);
    }

    /**
     * @Route("/user", name="_user")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getRepository(User::class)->findAll();
        return $this->render('admin/user.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="_user_delete")
     */
    public function deleteUser($id, ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if(!$user)
        {
            throw new \Exception("Aucun utilisateur pour l'id : $id");
        }

        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_user');
    }

    /**
     * @Route("/commandes", name="_commandes")
     */
    public function adminCommandes(ManagerRegistry $doctrine): Response
    {
        $commandes = $doctrine->getRepository(Commande::class)->findAll();

        return $this->render('admin/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/commande/delete/{id}", name="_commande_delete")
     */
    public function deleteCommande($id, ManagerRegistry $doctrine): Response
    {
        $commande = $doctrine->getRepository(Commande::class)->find($id);

        if(!$commande)
        {
            throw new \Exception("Aucun snowboard pour l'id : $id");
        }

        $em = $doctrine->getManager();
        $em->remove($commande);
        $em->flush();

        return $this->redirectToRoute('admin_commandes');
    }

    /**
     * @Route("/snowboards", name="_snowboards")
     */
    public function adminSnowboards(ManagerRegistry $doctrine): Response
    {
        $snowboards = $doctrine->getRepository(Snowboards::class)->findAll();

        return $this->render('admin/snowboards.html.twig', [
            'snowboards' => $snowboards,
        ]);
    }

    /**
     * @Route("/snowboard/update/{id}", name="_snowboard_update")
     */
    public function update($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $snowboards = $doctrine->getRepository(Snowboards::class)->find($id);
        $formSnowboards = $this->createForm(SnowboardsType::class, $snowboards);
        $formSnowboards->handleRequest($request);

        if($formSnowboards->isSubmitted() && $formSnowboards->isValid())
        {
            $snowboards->setUpdatedAt(new \DateTime());
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("admin_snowboards", ["id" => $snowboards->getId()]);
        }

        return $this->renderForm('admin/snow_update.html.twig', [
            'formSnowboards' => $formSnowboards,
            'snowboards' => $snowboards
        ]);
    }

    /**
     * @Route("/snowboard/delete/{id}", name="_snowboard_delete")
     */
    public function deleteSnowboards($id, ManagerRegistry $doctrine): Response
    {
        $snowboards = $doctrine->getRepository(Snowboards::class)->find($id);

        if(!$snowboards)
        {
            throw new \Exception("Aucun snowboard pour l'id : $id");
        }

        $em = $doctrine->getManager();
        $em->remove($snowboards);
        $em->flush();

        return $this->redirectToRoute('admin_snowboards');
    }
}
