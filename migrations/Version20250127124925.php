<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127124925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB6126F525E');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB6126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB6126F525E');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB6126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id)');
    }
}
