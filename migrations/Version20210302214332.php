<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302214332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinique (id INT AUTO_INCREMENT NOT NULL, nomclinique VARCHAR(255) NOT NULL, adresseclinique VARCHAR(255) NOT NULL, numtel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, typeintervention VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nommedecin VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD medecin_id INT NOT NULL, ADD intervention_id INT NOT NULL, ADD clinique_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('CREATE INDEX IDX_42C849554F31A84 ON reservation (medecin_id)');
        $this->addSql('CREATE INDEX IDX_42C849558EAE3863 ON reservation (intervention_id)');
        $this->addSql('CREATE INDEX IDX_42C84955265183A3 ON reservation (clinique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955265183A3');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558EAE3863');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554F31A84');
        $this->addSql('DROP TABLE clinique');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP INDEX IDX_42C849554F31A84 ON reservation');
        $this->addSql('DROP INDEX IDX_42C849558EAE3863 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955265183A3 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP medecin_id, DROP intervention_id, DROP clinique_id');
    }
}
