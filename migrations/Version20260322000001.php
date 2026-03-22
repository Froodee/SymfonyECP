<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260322000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table rendez_vous pour la prise de rendez-vous en ligne';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE rendez_vous (
            id INT IDENTITY NOT NULL,
            nom NVARCHAR(100) NOT NULL,
            email NVARCHAR(180) NOT NULL,
            telephone NVARCHAR(20) NOT NULL,
            service NVARCHAR(100) NOT NULL,
            date_rdv DATETIME2(6) NOT NULL,
            message NVARCHAR(500) NULL,
            statut NVARCHAR(20) NOT NULL,
            created_at DATETIME2(6) NOT NULL,
            PRIMARY KEY (id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE rendez_vous');
    }
}
