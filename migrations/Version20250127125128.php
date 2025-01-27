<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127125128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB659D8A214');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB659D8A214 FOREIGN KEY (recipe_id) REFERENCES oh_recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB659D8A214');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB659D8A214 FOREIGN KEY (recipe_id) REFERENCES oh_recipe (id)');
    }
}
