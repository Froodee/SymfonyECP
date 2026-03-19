<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('contact', $request->request->get('_token'))) {
                $this->addFlash('error', 'Formulaire invalide.');
                return $this->redirectToRoute('app_contact');
            }

            $name    = htmlspecialchars($request->request->get('name', ''));
            $email   = $request->request->get('email', '');
            $subject = htmlspecialchars($request->request->get('subject', ''));
            $message = htmlspecialchars($request->request->get('message', ''));

            if (!$name || !$email || !$subject || !$message) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_contact');
            }

            $emailMessage = (new Email())
                ->from('emballep@gmail.com')
                ->to('emballep@gmail.com')
                ->replyTo($email)
                ->subject('[Contact ECP] ' . $subject)
                ->text("De : $name ($email)\nSujet : $subject\n\n$message");

            $mailer->send($emailMessage);

            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_contact');
        }

        $session = $request->getSession();
        $successMessages = $session->getFlashBag()->get('success', []);
        $errorMessages   = $session->getFlashBag()->get('error', []);

        return $this->render('contact/index.html.twig', [
            'successMessages' => $successMessages,
            'errorMessages'   => $errorMessages,
        ]);
    }
}
