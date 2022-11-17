<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(ManagerRegistry $doctrine, Request $request, MailerInterface $mailer)
    {
        $contact = new Contact;
        $contact->setCreatedAt(new DateTime());

        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if($formContact->isSubmitted() && $formContact->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            //Envoi de l'email
            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to(new Address('admin@snowboards-area.com'))
            ->subject('Demande de contact')

            // path of the Twig template to render
            ->htmlTemplate('emails/contact.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'contact' => $contact
            ]);

            $confirm = (new TemplatedEmail())
            ->from(new Address('admin@snowboards-area.com'))
            ->to($contact->getEmail())
            ->subject('Accusé de réception de votre demande de contact')
            ->htmlTemplate('emails/accuse-reception.html.twig')
            ->context([
                'contact' => $contact
            ]);
            $mailer->send($email);
            $mailer->send($confirm);

            return $this->redirectToRoute('contact');
        }

        $this->addFlash('email_envoyer', "Nous vous répondrons dans les plus bref délais.");

        return $this->renderForm('contact/index.html.twig', [
            'formContact' => $formContact
        ]);
    }
}

