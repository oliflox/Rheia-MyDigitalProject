<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $address = $contactFormData['email'];
            $name = $contactFormData['firstname'] . ' ' . $contactFormData['lastname'];
            $object = $contactFormData['object'];
            $school = $contactFormData['school'];
            $message = $contactFormData['message'];

            if ($school == 'oui') {
                $school = 'Je suis personnel enseignant et je souhaite m\'inscrire au concours inter-écoles.';
            } else {
                $school = null;
            }

            $this->addFlash('success', 'Votre demande de contact à été envoyé avec succès !');


            $email = (new Email())
                ->from($address)
                ->to('admin@admin.com')
                ->subject($object)
                ->text("$school $name $message");


            $mailer->send($email);
        }


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $form,
        ]);
    }
}
