<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Produits;
use App\Entity\RendezVous;
use App\Entity\TypeProduit;
use App\Entity\Promo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECP – Administration')
            ->setFaviconPath('img/favicon.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::section('Boutique');
        yield MenuItem::linkToCrud('Produits', 'fa fa-box', Produits::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-tags', TypeProduit::class);
        yield MenuItem::linkToCrud('Promotions', 'fa fa-percent', Promo::class);
        yield MenuItem::section('Commandes');
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Commande::class);
        yield MenuItem::section('Rendez-vous');
        yield MenuItem::linkToCrud('Rendez-vous', 'fa fa-calendar', RendezVous::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToRoute('Demandes de validation', 'fa fa-user-check', 'app_admin_demandes');
        yield MenuItem::section('');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
    }
}
