<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer les informations détaillées de l'utilisateur
        $utilisateur = $user->getUtilisateur();

        // Récupérer les commandes de l'utilisateur (si disponibles)
        $commandes = $utilisateur ? $utilisateur->getCommandes() : [];

        // Récupérer les avis de l'utilisateur (si disponibles)
        $avis = $utilisateur ? $utilisateur->getAvis() : [];

        // Vérifier si c'est un client (avec SIRET)
        $client = $utilisateur ? $utilisateur->getClient() : null;

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'utilisateur' => $utilisateur,
            'commandes' => $commandes,
            'avis' => $avis,
            'client' => $client,
        ]);
    }
}
