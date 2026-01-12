<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260108074143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT IDENTITY NOT NULL, id_user_id INT, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D7679F37AE5 ON admin (id_user_id) WHERE id_user_id IS NOT NULL');
        $this->addSql('CREATE TABLE avis (id INT IDENTITY NOT NULL, ref_pds_id INT, id_user_id INT, commentaire NVARCHAR(500) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_8F91ABF043C10646 ON avis (ref_pds_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF079F37AE5 ON avis (id_user_id)');
        $this->addSql('CREATE TABLE client (id INT IDENTITY NOT NULL, id_user_id INT, siret NVARCHAR(14), PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045579F37AE5 ON client (id_user_id) WHERE id_user_id IS NOT NULL');
        $this->addSql('CREATE TABLE commande (id INT IDENTITY NOT NULL, id_user_id INT, num_cde SMALLINT NOT NULL, date_cde DATE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_6EEAA67D79F37AE5 ON commande (id_user_id)');
        $this->addSql('CREATE TABLE composition (id INT IDENTITY NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE connexion (id INT IDENTITY NOT NULL, login NVARCHAR(32) NOT NULL, password NVARCHAR(64) NOT NULL, idu SMALLINT NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE employe (id INT IDENTITY NOT NULL, id_user_id INT, no_secu NVARCHAR(13) NOT NULL, date_emp DATE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F804D3B979F37AE5 ON employe (id_user_id) WHERE id_user_id IS NOT NULL');
        $this->addSql('CREATE TABLE facture (id INT IDENTITY NOT NULL, num_cde_id INT, num_fact SMALLINT NOT NULL, date_fact DATE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE8664107FC94171 ON facture (num_cde_id) WHERE num_cde_id IS NOT NULL');
        $this->addSql('CREATE TABLE lien (id INT IDENTITY NOT NULL, id_user_con_id INT, id_user_id INT, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A532B4B51B797613 ON lien (id_user_con_id) WHERE id_user_con_id IS NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A532B4B579F37AE5 ON lien (id_user_id) WHERE id_user_id IS NOT NULL');
        $this->addSql('CREATE TABLE panier (id INT IDENTITY NOT NULL, num_cde_id INT, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF27FC94171 ON panier (num_cde_id) WHERE num_cde_id IS NOT NULL');
        $this->addSql('CREATE TABLE produits (id INT IDENTITY NOT NULL, panier_id INT, id_promo_id INT, code_typ_id INT, ref_pds SMALLINT NOT NULL, qtepds SMALLINT NOT NULL, prix_pds NUMERIC(10, 2) NOT NULL, lib_pds NVARCHAR(32) NOT NULL, desc_pds NVARCHAR(512) NOT NULL, design_pds NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_BE2DDF8CF77D927C ON produits (panier_id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C801B966A ON produits (id_promo_id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C580A88D6 ON produits (code_typ_id)');
        $this->addSql('CREATE TABLE promo (id INT IDENTITY NOT NULL, date_db DATE NOT NULL, date_fin DATE NOT NULL, reduc NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE type_produit (id INT IDENTITY NOT NULL, code_typ SMALLINT NOT NULL, lib_typ NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE utilisateurs (id INT IDENTITY NOT NULL, id_user SMALLINT NOT NULL, nom_user NVARCHAR(64) NOT NULL, adr_user NVARCHAR(64) NOT NULL, cp_user NVARCHAR(5) NOT NULL, ville_user NVARCHAR(64) NOT NULL, num_user NVARCHAR(10) NOT NULL, email_user NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT IDENTITY NOT NULL, body VARCHAR(MAX) NOT NULL, headers VARCHAR(MAX) NOT NULL, queue_name NVARCHAR(190) NOT NULL, created_at DATETIME2(6) NOT NULL, available_at DATETIME2(6) NOT NULL, delivered_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'created_at\'');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'available_at\'');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'messenger_messages\', N\'COLUMN\', \'delivered_at\'');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7679F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF043C10646 FOREIGN KEY (ref_pds_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF079F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045579F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B979F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107FC94171 FOREIGN KEY (num_cde_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE lien ADD CONSTRAINT FK_A532B4B51B797613 FOREIGN KEY (id_user_con_id) REFERENCES connexion (id)');
        $this->addSql('ALTER TABLE lien ADD CONSTRAINT FK_A532B4B579F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF27FC94171 FOREIGN KEY (num_cde_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C801B966A FOREIGN KEY (id_promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C580A88D6 FOREIGN KEY (code_typ_id) REFERENCES type_produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE admin DROP CONSTRAINT FK_880E0D7679F37AE5');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF043C10646');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF079F37AE5');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C744045579F37AE5');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D79F37AE5');
        $this->addSql('ALTER TABLE employe DROP CONSTRAINT FK_F804D3B979F37AE5');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE8664107FC94171');
        $this->addSql('ALTER TABLE lien DROP CONSTRAINT FK_A532B4B51B797613');
        $this->addSql('ALTER TABLE lien DROP CONSTRAINT FK_A532B4B579F37AE5');
        $this->addSql('ALTER TABLE panier DROP CONSTRAINT FK_24CC0DF27FC94171');
        $this->addSql('ALTER TABLE produits DROP CONSTRAINT FK_BE2DDF8CF77D927C');
        $this->addSql('ALTER TABLE produits DROP CONSTRAINT FK_BE2DDF8C801B966A');
        $this->addSql('ALTER TABLE produits DROP CONSTRAINT FK_BE2DDF8C580A88D6');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE connexion');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE lien');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE type_produit');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
