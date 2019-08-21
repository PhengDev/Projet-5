<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820213049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property CHANGE type type INT NOT NULL, CHANGE color color INT NOT NULL, CHANGE personage personage INT NOT NULL, CHANGE origin origin INT NOT NULL, CHANGE era era INT NOT NULL, CHANGE series series INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property CHANGE type type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE series series VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE color color VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE origin origin VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE era era VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE personage personage VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
