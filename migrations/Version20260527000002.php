<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260527000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table demande_validation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE demande_validation (
            id INT IDENTITY NOT NULL,
            user_id INT NOT NULL,
            fichier_pdf NVARCHAR(255) NOT NULL,
            statut NVARCHAR(20) NOT NULL DEFAULT \'en_attente\',
            date_creation DATETIME2 NOT NULL,
            PRIMARY KEY (id)
        )');
        $this->addSql('ALTER TABLE demande_validation ADD CONSTRAINT FK_DV_USER FOREIGN KEY (user_id) REFERENCES [user] (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE demande_validation DROP CONSTRAINT FK_DV_USER');
        $this->addSql('DROP TABLE demande_validation');
    }
}
