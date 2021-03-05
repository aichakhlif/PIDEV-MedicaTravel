<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304023655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_offre ADD offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation_offre ADD CONSTRAINT FK_ECF956C84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_ECF956C84CC8505A ON reservation_offre (offre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_offre DROP FOREIGN KEY FK_ECF956C84CC8505A');
        $this->addSql('DROP INDEX IDX_ECF956C84CC8505A ON reservation_offre');
        $this->addSql('ALTER TABLE reservation_offre DROP offre_id');
    }
}
