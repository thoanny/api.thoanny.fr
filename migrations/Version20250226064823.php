<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226064823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_server ADD slug VARCHAR(25) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58EF0CDE5E237E06 ON oh_server (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58EF0CDE989D9B62 ON oh_server (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_58EF0CDE5E237E06 ON oh_server');
        $this->addSql('DROP INDEX UNIQ_58EF0CDE989D9B62 ON oh_server');
        $this->addSql('ALTER TABLE oh_server DROP slug');
    }
}
