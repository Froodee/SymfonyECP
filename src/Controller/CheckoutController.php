<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Facture;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CheckoutController extends AbstractController
{
    #[Route('/commander', name: 'app_checkout')]
    public function index(SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (empty($panier)) {
            return $this->redirectToRoute('app_panier');
        }

        $sousTotal = 0;
        foreach ($panier as $item) {
            $produit = $item['produit'];
            $prix = $this->getPrixEffectif($produit);
            $sousTotal += $prix * $item['quantite'];
        }

        $fraisLivraison = 6.90;
        $total = $sousTotal + $fraisLivraison;

        return $this->render('checkout/index.html.twig', [
            'panier'         => $panier,
            'sousTotal'      => $sousTotal,
            'fraisLivraison' => $fraisLivraison,
            'total'          => $total,
            'utilisateur'    => $this->getUser()->getUtilisateur(),
        ]);
    }

    #[Route('/commander/confirmer', name: 'app_checkout_confirmer', methods: ['POST'])]
    public function confirmer(
        Request $request,
        SessionInterface $session,
        EntityManagerInterface $em,
        CommandeRepository $commandeRepository,
        MailerInterface $mailer
    ): Response {
        if (!$this->isCsrfTokenValid('checkout', $request->request->get('_token'))) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_checkout');
        }

        $panier = $session->get('panier', []);
        if (empty($panier)) {
            return $this->redirectToRoute('app_panier');
        }

        $sousTotal = 0;
        foreach ($panier as $item) {
            $prix = $this->getPrixEffectif($item['produit']);
            $sousTotal += $prix * $item['quantite'];
        }
        $total = $sousTotal + 6.90;

        $utilisateur = $this->getUser()->getUtilisateur();

        // Créer la commande
        $commande = new Commande();
        $commande->setNumCde(($commandeRepository->count([]) + 1));
        $commande->setDateCde(new \DateTime());
        $commande->setIdUser($utilisateur);

        // Créer la facture
        $facture = new Facture();
        $facture->setNumFact($commande->getNumCde());
        $facture->setDateFact(new \DateTime());
        $facture->setMontant((string) $total);
        $facture->setNumCde($commande);

        $em->persist($commande);
        $em->persist($facture);
        $em->flush();

        // Vider le panier
        $session->remove('panier');
        $session->set('nbre', 0);

        // Email de confirmation
        $userEmail = $this->getUser()->getUserIdentifier();
        $email = (new TemplatedEmail())
            ->from(new Address('emballep@gmail.com', 'ECP – Emballé c\'est pesé'))
            ->to($userEmail)
            ->subject('Confirmation de votre commande #' . $commande->getNumCde())
            ->htmlTemplate('checkout/email_confirmation.html.twig')
            ->context([
                'commande' => $commande,
                'facture'  => $facture,
                'panier'   => $panier,
                'total'    => $total,
            ]);
        $mailer->send($email);

        return $this->redirectToRoute('app_checkout_confirmation', ['id' => $facture->getId()]);
    }

    #[Route('/commander/confirmation/{id}', name: 'app_checkout_confirmation')]
    public function confirmation(Facture $facture): Response
    {
        if ($facture->getNumCde()?->getIdUser()?->getId() !== $this->getUser()->getUtilisateur()?->getId()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('checkout/confirmation.html.twig', [
            'facture'  => $facture,
            'commande' => $facture->getNumCde(),
        ]);
    }

    private function getPrixEffectif($produit): float
    {
        $promo = $produit->getIdPromo();
        if ($promo) {
            $now = new \DateTime();
            if ($now >= $promo->getDateDb() && $now <= $promo->getDateFin()) {
                return (float) $produit->getPrixPds() * (1 - (float) $promo->getReduc() / 100);
            }
        }
        return (float) $produit->getPrixPds();
    }
}
