<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendez-vous', name: 'app_rendez_vous')]
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $rdv = new RendezVous();

        // Pré-remplir l'email si l'utilisateur est connecté
        if ($this->getUser()) {
            $rdv->setEmail($this->getUser()->getUserIdentifier());
        }

        $form = $this->createForm(RendezVousType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rdv->setCreatedAt(new \DateTime());
            $em->persist($rdv);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('emballep@gmail.com', 'ECP – Emballé c\'est pesé'))
                ->to($rdv->getEmail())
                ->subject('Votre demande de rendez-vous – ECP')
                ->htmlTemplate('rendez_vous/email_confirmation.html.twig')
                ->context(['rdv' => $rdv]);

            $mailer->send($email);

            // Notification à l'admin
            $emailAdmin = (new TemplatedEmail())
                ->from(new Address('emballep@gmail.com', 'ECP – Emballé c\'est pesé'))
                ->to('emballep@gmail.com')
                ->subject('Nouveau RDV : ' . $rdv->getNom() . ' – ' . $rdv->getService())
                ->htmlTemplate('rendez_vous/email_admin_rdv.html.twig')
                ->context(['rdv' => $rdv]);
            $mailer->send($emailAdmin);

            return $this->redirectToRoute('app_rendez_vous_confirmation', [
                'nom'     => $rdv->getNom(),
                'service' => $rdv->getService(),
                'date'    => $rdv->getDateRdv()->format('d/m/Y à H\hi'),
            ]);
        }

        return $this->render('rendez_vous/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/rendez-vous/confirmation', name: 'app_rendez_vous_confirmation')]
    public function confirmation(Request $request): Response
    {
        return $this->render('rendez_vous/confirmation.html.twig', [
            'nom'     => $request->query->get('nom', ''),
            'service' => $request->query->get('service', ''),
            'date'    => $request->query->get('date', ''),
        ]);
    }
}
