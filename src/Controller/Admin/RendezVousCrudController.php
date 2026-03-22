<?php

namespace App\Controller\Admin;

use App\Entity\RendezVous;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class RendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RendezVous::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('email', 'Email'),
            TextField::new('telephone', 'Téléphone'),
            TextField::new('service', 'Service'),
            DateTimeField::new('dateRdv', 'Date souhaitée'),
            TextareaField::new('message', 'Message')->hideOnIndex(),
            ChoiceField::new('statut', 'Statut')->setChoices([
                'En attente'  => 'en_attente',
                'Confirmé'    => 'confirme',
                'Annulé'      => 'annule',
            ]),
            DateTimeField::new('createdAt', 'Reçu le')->hideOnForm(),
        ];
    }
}
