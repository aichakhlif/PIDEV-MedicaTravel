<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309144047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6265183A3 FOREIGN KEY (clinique_id) REFERENCES clinique (id)');
        $this->addSql('CREATE INDEX IDX_1BDA53C6265183A3 ON medecin (clinique_id)');
        $this->addSql('ALTER TABLE offre ADD date DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6265183A3');
        $this->addSql('DROP INDEX IDX_1BDA53C6265183A3 ON medecin');
        $this->addSql('ALTER TABLE offre DROP date');
    }
}
