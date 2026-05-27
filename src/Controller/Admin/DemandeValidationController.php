<?php

namespace App\Controller\Admin;

use App\Repository\DemandeValidationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DemandeValidationController extends AbstractController
{
    #[Route('/admin/demandes', name: 'app_admin_demandes')]
    public function index(DemandeValidationRepository $demandeRepo): Response
    {
        $demandes = $demandeRepo->findBy([], ['dateCreation' => 'DESC']);

        return $this->render('admin/demandes_validation.html.twig', [
            'demandes' => $demandes,
        ]);
    }

    #[Route('/admin/demandes/{id}/valider', name: 'app_admin_demandes_valider', methods: ['POST'])]
    public function valider(int $id, DemandeValidationRepository $demandeRepo, EntityManagerInterface $em): Response
    {
        $demande = $demandeRepo->find($id);
        if (!$demande) {
            throw $this->createNotFoundException();
        }

        $demande->setStatut('valide');
        $demande->getUser()->setEstValide(true);
        $em->flush();

        $this->addFlash('success', 'Utilisateur validé avec succès.');
        return $this->redirectToRoute('app_admin_demandes');
    }

    #[Route('/admin/demandes/{id}/refuser', name: 'app_admin_demandes_refuser', methods: ['POST'])]
    public function refuser(int $id, DemandeValidationRepository $demandeRepo, EntityManagerInterface $em): Response
    {
        $demande = $demandeRepo->find($id);
        if (!$demande) {
            throw $this->createNotFoundException();
        }

        $demande->setStatut('refuse');
        $em->flush();

        $this->addFlash('warning', 'Demande refusée.');
        return $this->redirectToRoute('app_admin_demandes');
    }
}
