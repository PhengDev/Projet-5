<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190814131151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property ADD type VARCHAR(255) NOT NULL, ADD color VARCHAR(255) NOT NULL, ADD power INT NOT NULL, ADD cost_energy INT NOT NULL, ADD cost_combo INT NOT NULL, ADD power_combo INT NOT NULL, ADD `character` VARCHAR(255) NOT NULL, ADD origine VARCHAR(255) NOT NULL, ADD era VARCHAR(255) NOT NULL, ADD series VARCHAR(255) NOT NULL, ADD rarity VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP type, DROP color, DROP power, DROP cost_energy, DROP cost_combo, DROP power_combo, DROP `character`, DROP origine, DROP era, DROP series, DROP rarity');
    }
}
