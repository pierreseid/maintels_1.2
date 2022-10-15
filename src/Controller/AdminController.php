<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController


{
    /**
     * @Route("/ajout-user", name="user-ajout")
     */
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new user();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            
        // $user->setTimestamp(now);
           
            
            $manager->persist($user);
            $manager->flush();

        }
    
        return $this->render('admin/formulaire.html.twig', [
            'formUser' => $form->createView()
        ]);
    }


    /**
     * @Route("/gestion-users", name="gestion_userss")
     */
    public function gestionUsers(UserRepository $repo)
    {
        $users = $repo->findAll();

        return $this->render("admin/gestion-users.html.twig", [
            'users' => $users
        ]);

    }

    /**
     *@Route("/details-user-{id<\d+>}", name="details_user")
     */
    public function detailsUser($id, UserRepository $repo)
    {
        $user = $repo->find($id);

        
        return $this->render("admin/details-user.html.twig", [
            'user' => $user
        ]);
    }

    /**
     * @Route("/update-user-{id<\d+>}", name="update_user")
     */
    public function update($id, UserRepository $repo, Request $request)
    {
        $user = $repo->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            
            $repo->add($user, 1);

            return $this->redirectToRoute("admin_gestion_user");
        }

        return $this->render("admin/formulaire.html.twig", [
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete-user-{id<\d+>}", name="delete_user")
     */
    public function delete($id, UserRepository $repo)
    {
        $user = $repo->find($id);

        $repo->remove($user, 1);

        return $this->redirectToRoute("admin_gestion_user");
    }








}
