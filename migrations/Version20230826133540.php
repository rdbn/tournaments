<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826133540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table tournaments, teams.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        CREATE TABLE IF NOT EXISTS tournaments(
            id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            match_teams JSON DEFAULT NULL,
            updated_at DATETIME NOT NULL DEFAULT now(),
            created_at DATETIME NOT NULL DEFAULT now(),
            CONSTRAINT UNIQ_tournaments_name UNIQUE(name)
        ) ENGINE innoDB COLLATE utf8mb4_general_ci;
        ');

        $this->addSql('
        CREATE TABLE IF NOT EXISTS teams(
            id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            updated_at DATETIME NOT NULL DEFAULT now(),
            created_at DATETIME NOT NULL DEFAULT now(),
            CONSTRAINT UNIQ_teams_name UNIQUE(name)
        ) ENGINE innoDB COLLATE utf8mb4_general_ci;
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS tournaments;');
        $this->addSql('DROP TABLE IF EXISTS teams;');
    }
}
