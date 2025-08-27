<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321163323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_file (id INT AUTO_INCREMENT NOT NULL, folder_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, mime_type INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4FD8E9C3162CB942 (folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_file ADD CONSTRAINT FK_4FD8E9C3162CB942 FOREIGN KEY (folder_id) REFERENCES media_folder (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_file DROP FOREIGN KEY FK_4FD8E9C3162CB942');
        $this->addSql('DROP TABLE media_file');
    }
}
