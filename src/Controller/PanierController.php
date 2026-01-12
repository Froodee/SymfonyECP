<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session): Response
    {
        // Récupérer le panier depuis la session
        $panier = $session->get('panier', []);

        // Calculer le sous-total
        $sousTotal = 0;
        foreach ($panier as $item) {
            $sousTotal += $item['produit']->getPrixPds() * $item['quantite'];
        }

        // Frais de livraison
        $fraisLivraison = 6.90;

        // Total
        $total = $sousTotal + $fraisLivraison;

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'sousTotal' => $sousTotal,
            'fraisLivraison' => $fraisLivraison,
            'total' => $total,
        ]);
    }

    #[Route('/panier/augmenter/{id}', name: 'app_panier_augmenter')]
    public function augmenter(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
            $session->set('panier', $panier);
            $session->set('nbre', array_sum(array_column($panier, 'quantite')));
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/diminuer/{id}', name: 'app_panier_diminuer')]
    public function diminuer(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            if ($panier[$id]['quantite'] > 1) {
                $panier[$id]['quantite']--;
            } else {
                // Si quantité = 1, on supprime le produit
                unset($panier[$id]);
            }
            $session->set('panier', $panier);
            $session->set('nbre', array_sum(array_column($panier, 'quantite')));
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    public function supprimer(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $session->set('nbre', array_sum(array_column($panier, 'quantite')));
            $this->addFlash('success', 'Produit retiré du panier');
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/vider', name: 'app_panier_vider')]
    public function vider(SessionInterface $session): Response
    {
        $session->remove('panier');
        $session->set('nbre', 0);
        $this->addFlash('success', 'Panier vidé avec succès');

        return $this->redirectToRoute('app_panier');
    }
}
