<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        // Récupérer tous les produits (sans filtrer par stock pour l'instant)
        $produits = $produitsRepository->findAll();

        return $this->render('boutique/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/boutique/ajouter/{id}', name: 'app_boutique_ajouter')]
    public function ajouterAuPanier(
        Produits $produit,
        SessionInterface $session,
        Request $request
    ): Response {
        // Récupérer le panier depuis la session (ou créer un tableau vide)
        $panier = $session->get('panier', []);

        $id = $produit->getId();

        // Si le produit existe déjà dans le panier, on incrémente la quantité
        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            // Sinon on l'ajoute avec quantité 1
            $panier[$id] = [
                'produit' => $produit,
                'quantite' => 1
            ];
        }

        // Mettre à jour le panier en session
        $session->set('panier', $panier);

        // Mettre à jour le nombre d'articles
        $session->set('nbre', array_sum(array_column($panier, 'quantite')));

        // Message flash de confirmation
        $this->addFlash('success', 'Produit ajouté au panier avec succès !');

        // Rediriger vers la page précédente ou la boutique
        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?: $this->generateUrl('app_boutique'));
    }
}