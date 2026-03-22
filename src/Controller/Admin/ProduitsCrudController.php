<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('LibPds', 'Nom'),
            TextareaField::new('DescPds', 'Description')->hideOnIndex(),
            TextField::new('PrixPds', 'Prix (€)'),
            IntegerField::new('Qtepds', 'Stock'),
            TextField::new('DesignPds', 'Image (nom fichier)'),
            AssociationField::new('CodeTyp', 'Catégorie'),
            AssociationField::new('IdPromo', 'Promotion')->hideOnIndex(),
        ];
    }
}
