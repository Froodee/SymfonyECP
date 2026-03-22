<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260322000003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne montant dans la table facture';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE facture ADD montant DECIMAL(10, 2) NOT NULL DEFAULT '0.00'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE facture DROP COLUMN montant');
    }
}
