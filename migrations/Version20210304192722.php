<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304192722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous ADD medecin_id INT NOT NULL, ADD nom_m VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A4F31A84 ON rendez_vous (medecin_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('DROP INDEX IDX_65E8AA0A4F31A84 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP medecin_id, DROP nom_m');
    }
}
