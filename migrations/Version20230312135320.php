<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312135320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rank AS SELECT id, name, value, picture, abbreviation FROM rank');
        $this->addSql('DROP TABLE rank');
        $this->addSql('CREATE TABLE rank (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value CLOB NOT NULL --(DC2Type:array)
        , picture VARCHAR(255) DEFAULT NULL, abbreviation CLOB DEFAULT NULL --(DC2Type:array)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO rank (id, name, value, picture, abbreviation) SELECT id, name, value, picture, abbreviation FROM __temp__rank');
        $this->addSql('DROP TABLE __temp__rank');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rank AS SELECT id, name, value, picture, abbreviation FROM rank');
        $this->addSql('DROP TABLE rank');
        $this->addSql('CREATE TABLE rank (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value CLOB NOT NULL --(DC2Type:array)
        , picture VARCHAR(255) DEFAULT NULL, abbreviation CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO rank (id, name, value, picture, abbreviation) SELECT id, name, value, picture, abbreviation FROM __temp__rank');
        $this->addSql('DROP TABLE __temp__rank');
    }
}
