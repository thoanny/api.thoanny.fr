<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260817160115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vestigia_loot_item (id INT AUTO_INCREMENT NOT NULL, reward_item_id INT NOT NULL, item_id INT NOT NULL, min INT NOT NULL, max INT NOT NULL, chance INT NOT NULL, INDEX IDX_BAB29B89F8D8AFA6 (reward_item_id), INDEX IDX_BAB29B89126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vestigia_loot_item ADD CONSTRAINT FK_BAB29B89F8D8AFA6 FOREIGN KEY (reward_item_id) REFERENCES vestigia_item (id)');
        $this->addSql('ALTER TABLE vestigia_loot_item ADD CONSTRAINT FK_BAB29B89126F525E FOREIGN KEY (item_id) REFERENCES vestigia_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vestigia_loot_item DROP FOREIGN KEY FK_BAB29B89F8D8AFA6');
        $this->addSql('ALTER TABLE vestigia_loot_item DROP FOREIGN KEY FK_BAB29B89126F525E');
        $this->addSql('DROP TABLE vestigia_loot_item');
    }
}
