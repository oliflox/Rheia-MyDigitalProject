<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AddressType;
use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/EditUserInfo', name: 'user_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->doctrine = $doctrine;
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil à bien été modifié');
            return $this->redirectToRoute("user_index");
        }


        return $this->render('user/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/EditUserAdress', name: 'edit_adress')]
    public function EditAdress(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        $address = new Adress();
        $address->setUser($user);

        $AdressForm = $this->createForm(AddressType::class, $address);

        $AdressForm->handleRequest($request);

        if ($AdressForm->isSubmitted() && $AdressForm->isValid()) {

            $this->doctrine = $doctrine;
            $em = $doctrine->getManager();
            $em->persist($address);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle adresse à bien été modifié');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/editAddress.html.twig', [
            'form' => $AdressForm->createView()
        ]);
    }

    #[Route('/adress', name: 'user_adress')]
    public function adress(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/address.html.twig');
    }
}
