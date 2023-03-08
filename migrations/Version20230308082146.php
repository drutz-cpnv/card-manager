<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308082146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card ADD COLUMN rank_picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__card AS SELECT id, employee_id, print_request_id, firstname, lastname, role, rank, number, birthdate, picture, uid, legal_text, role_type, to_print, created_at, updated_at FROM card');
        $this->addSql('DROP TABLE card');
        $this->addSql('CREATE TABLE card (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER DEFAULT NULL, print_request_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, rank VARCHAR(255) NOT NULL, number INTEGER DEFAULT NULL, birthdate DATE NOT NULL --(DC2Type:date_immutable)
        , picture VARCHAR(255) NOT NULL, uid VARCHAR(11) NOT NULL, legal_text CLOB NOT NULL, role_type VARCHAR(255) NOT NULL, to_print BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_161498D38C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_161498D32667764C FOREIGN KEY (print_request_id) REFERENCES print_request (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card (id, employee_id, print_request_id, firstname, lastname, role, rank, number, birthdate, picture, uid, legal_text, role_type, to_print, created_at, updated_at) SELECT id, employee_id, print_request_id, firstname, lastname, role, rank, number, birthdate, picture, uid, legal_text, role_type, to_print, created_at, updated_at FROM __temp__card');
        $this->addSql('DROP TABLE __temp__card');
        $this->addSql('CREATE INDEX IDX_161498D38C03F15C ON card (employee_id)');
        $this->addSql('CREATE INDEX IDX_161498D32667764C ON card (print_request_id)');
    }
}
