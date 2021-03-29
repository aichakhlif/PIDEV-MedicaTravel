<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311161823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention ADD specialite_id INT NOT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D11814AB2195E0F0 ON intervention (specialite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB2195E0F0');
        $this->addSql('DROP INDEX UNIQ_D11814AB2195E0F0 ON intervention');
        $this->addSql('ALTER TABLE intervention DROP specialite_id');
    }
}
