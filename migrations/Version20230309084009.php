<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309084009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rank ADD COLUMN abbreviation CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rank AS SELECT id, name, value, picture FROM rank');
        $this->addSql('DROP TABLE rank');
        $this->addSql('CREATE TABLE rank (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value CLOB NOT NULL --(DC2Type:array)
        , picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO rank (id, name, value, picture) SELECT id, name, value, picture FROM __temp__rank');
        $this->addSql('DROP TABLE __temp__rank');
    }
}
