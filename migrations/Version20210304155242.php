<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304155242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinique (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, clinique_id INT NOT NULL, medecin_id INT NOT NULL, intervention_id INT NOT NULL, INDEX IDX_AF86866F265183A3 (clinique_id), INDEX IDX_AF86866F4F31A84 (medecin_id), INDEX IDX_AF86866F8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F265183A3');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F8EAE3863');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F4F31A84');
        $this->addSql('DROP TABLE clinique');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE offre');
    }
}
