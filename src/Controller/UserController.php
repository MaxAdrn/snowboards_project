<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="_index")
     */
    public function index(ManagerRegistry $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/detail/{id}", name="_detail")
     */
    public function detail($id, ManagerRegistry $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        return $this->render('user/detail.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/add", name="_add")
     */
    public function add(ManagerRegistry $doctrine, Request $request)
    {
        $user = new User;
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid())
        {
            $user->setCreatedAt(new \DateTime());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("user_index");
        }

        return $this->renderForm('user/add.html.twig', [
            'formUser' => $formUser
        ]);
    }

    /**
     * @Route("/update/{id}", name="_update")
     */
    public function update($id, ManagerRegistry $doctrine, Request $request)
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid())
        {
            $user->setUpdatedAt(new \DateTime());
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("user_detail", ["id" => $user->getId()]);
        }

        return $this->renderForm('user/update.html.twig', [
            'formUser' => $formUser,
            'user' => $user
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete")
     */
    public function delete($id, ManagerRegistry $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if(!$user)
        {
            throw new \Exception("Aucun utilisateur pour l'id : $id");
        }

        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();

        // $this->addFlash("users_delete_ok", "L'utilisateur ".$user->getName()."a bien été supprimé !");

        return $this->redirectToRoute('user_index');
    }


    // /**
    //  * @Route("/role", name="_role")
    //  */
    // public function role($id, ManagerRegistry $doctrine, Request $request)
    // {
    //     $users = $doctrine->getRepository(Users::class)->find($id);
    //     $usersForm = $this->createForm(UsersType::class, $users);
    //     $usersForm->handleRequest($request);

    //     if($usersForm->isSubmitted() && $usersForm->isValid())
    //     {
    //         $users->setUpdatedAt(new \datetime());
    //         $entityManager = $doctrine->getManager();
    //         $entityManager->flush();

    //         return $this->redirectToRoute("_users_index");
    //     }

    //     return $this->renderForm('users/update.html.twig', [
    //         'usersForm' => $usersForm
    //     ]);
    // }
}