<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use App\Repository\TypeProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(Request $request, ProduitsRepository $produitsRepository, TypeProduitRepository $typeProduitRepository): Response
    {
        $typeId = $request->query->get('type');
        $categories = $typeProduitRepository->findAll();

        if ($typeId) {
            $produits = $produitsRepository->findBy(['CodeTyp' => $typeId]);
        } else {
            $produits = $produitsRepository->findAll();
        }

        return $this->render('boutique/index.html.twig', [
            'produits'    => $produits,
            'categories'  => $categories,
            'typeActif'   => $typeId,
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

    #[Route('/boutique/avis/{id}', name: 'app_boutique_avis', methods: ['POST'])]
    public function ajouterAvis(Produits $produit, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if (!$this->isCsrfTokenValid('avis_' . $produit->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_boutique');
        }

        $commentaire = trim($request->request->get('commentaire', ''));
        if (!$commentaire) {
            $this->addFlash('error', 'Le commentaire ne peut pas être vide.');
            return $this->redirectToRoute('app_boutique');
        }

        $note = (int) $request->request->get('note', 5);
        $utilisateur = $this->getUser()->getUtilisateur();

        $avis = new Avis();
        $avis->setCommentaire($commentaire);
        $avis->setNote($note);
        $avis->setRefPds($produit);
        $avis->setUser($this->getUser());
        if ($utilisateur) {
            $avis->setIdUser($utilisateur);
        }

        $em->persist($avis);
        $em->flush();

        $this->addFlash('success', 'Votre avis a été publié !');
        return $this->redirectToRoute('app_boutique');
    }
}