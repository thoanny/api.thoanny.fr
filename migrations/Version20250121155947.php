<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121155947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_memetic ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oh_memetic ADD CONSTRAINT FK_44A5D2DC727ACA70 FOREIGN KEY (parent_id) REFERENCES oh_memetic (id)');
        $this->addSql('CREATE INDEX IDX_44A5D2DC727ACA70 ON oh_memetic (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_memetic DROP FOREIGN KEY FK_44A5D2DC727ACA70');
        $this->addSql('DROP INDEX IDX_44A5D2DC727ACA70 ON oh_memetic');
        $this->addSql('ALTER TABLE oh_memetic DROP parent_id');
    }
}
