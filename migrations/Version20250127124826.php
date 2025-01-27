<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127124826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F1FDCE57C');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F1FDCE57C FOREIGN KEY (workshop_id) REFERENCES oh_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F1FDCE57C');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F1FDCE57C FOREIGN KEY (workshop_id) REFERENCES oh_item (id)');
    }
}
