<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260527000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de estReglemente sur produits et estValide sur user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE produits ADD est_reglemente BIT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE [user] ADD est_valide BIT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE produits DROP COLUMN est_reglemente');
        $this->addSql('ALTER TABLE [user] DROP COLUMN est_valide');
    }
}
