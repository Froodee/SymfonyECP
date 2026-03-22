<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260322000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne note (1-5) dans la table avis';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis ADD note SMALLINT NOT NULL DEFAULT 5');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis DROP COLUMN note');
    }
}
