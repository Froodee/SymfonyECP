<?php

namespace App\Controller;

use App\Entity\DemandeValidation;
use App\Repository\DemandeValidationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_USER')]
final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(DemandeValidationRepository $demandeRepo): Response
    {
        $user = $this->getUser();
        $utilisateur = $user->getUtilisateur();
        $commandes = $utilisateur ? $utilisateur->getCommandes() : [];
        $avis = $utilisateur ? $utilisateur->getAvis() : [];
        $client = $utilisateur ? $utilisateur->getClient() : null;

        $demande = $demandeRepo->findOneBy(['user' => $user], ['dateCreation' => 'DESC']);

        return $this->render('profil/index.html.twig', [
            'user'        => $user,
            'utilisateur' => $utilisateur,
            'commandes'   => $commandes,
            'avis'        => $avis,
            'client'      => $client,
            'demande'     => $demande,
        ]);
    }

    #[Route('/profil/demande-validation', name: 'app_profil_demande_validation', methods: ['POST'])]
    public function demandeValidation(
        Request $request,
        EntityManagerInterface $em,
        DemandeValidationRepository $demandeRepo,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser();

        if ($user->isEstValide()) {
            $this->addFlash('info', 'Votre compte est déjà validé.');
            return $this->redirectToRoute('app_profil');
        }

        $demandeExistante = $demandeRepo->findOneBy(['user' => $user, 'statut' => 'en_attente']);
        if ($demandeExistante) {
            $this->addFlash('warning', 'Une demande est déjà en cours de traitement.');
            return $this->redirectToRoute('app_profil');
        }

        if (!$this->isCsrfTokenValid('demande_validation', $request->request->get('_token'))) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_profil');
        }

        $fichier = $request->files->get('fichier_pdf');
        if (!$fichier || !$fichier->isValid()) {
            $erreur = $fichier ? $fichier->getErrorMessage() : 'Aucun fichier reçu.';
            $this->addFlash('error', 'Erreur lors de l\'upload : ' . $erreur . ' Vérifiez que le fichier ne dépasse pas la limite autorisée par le serveur.');
            return $this->redirectToRoute('app_profil');
        }

        if ($fichier->getMimeType() !== 'application/pdf') {
            $this->addFlash('error', 'Le fichier doit être au format PDF.');
            return $this->redirectToRoute('app_profil');
        }

        $nomOriginal = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
        $nomSafe = $slugger->slug($nomOriginal);
        $nomFichier = $nomSafe . '-' . uniqid() . '.pdf';

        $dossier = $this->getParameter('kernel.project_dir') . '/public/uploads/demandes';
        if (!is_dir($dossier)) {
            mkdir($dossier, 0755, true);
        }

        $fichier->move($dossier, $nomFichier);

        $demande = new DemandeValidation();
        $demande->setUser($user);
        $demande->setFichierPdf($nomFichier);

        $em->persist($demande);
        $em->flush();

        $this->addFlash('success', 'Votre demande de validation a bien été envoyée. Nous reviendrons vers vous rapidement.');
        return $this->redirectToRoute('app_profil');
    }
}
