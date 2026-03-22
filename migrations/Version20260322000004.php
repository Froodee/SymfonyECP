<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260322000004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la relation user_id (User) dans la table avis';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis ADD user_id INT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_AVIS_USER FOREIGN KEY (user_id) REFERENCES [user] (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_AVIS_USER');
        $this->addSql('ALTER TABLE avis DROP COLUMN user_id');
    }
}
