<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115200229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_item_scenario (item_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_FA041176126F525E (item_id), INDEX IDX_FA041176E04E49DF (scenario_id), PRIMARY KEY(item_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_item_scenario ADD CONSTRAINT FK_FA041176126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_item_scenario ADD CONSTRAINT FK_FA041176E04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_item_scenario DROP FOREIGN KEY FK_FA041176126F525E');
        $this->addSql('ALTER TABLE oh_item_scenario DROP FOREIGN KEY FK_FA041176E04E49DF');
        $this->addSql('DROP TABLE oh_item_scenario');
    }
}
