<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903120134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add column slug for table tournaments';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tournaments ADD COLUMN slug VARCHAR(255) NOT NULL AFTER name;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tournaments DROP COLUMN slug;');
    }
}
