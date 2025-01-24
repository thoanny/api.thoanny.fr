<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122163217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_server_server_tag (server_id INT NOT NULL, server_tag_id INT NOT NULL, INDEX IDX_7A52C8DB1844E6B7 (server_id), INDEX IDX_7A52C8DBC3AE5AD7 (server_tag_id), PRIMARY KEY(server_id, server_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_server_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_server_server_tag ADD CONSTRAINT FK_7A52C8DB1844E6B7 FOREIGN KEY (server_id) REFERENCES oh_server (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_server_server_tag ADD CONSTRAINT FK_7A52C8DBC3AE5AD7 FOREIGN KEY (server_tag_id) REFERENCES oh_server_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_server_server_tag DROP FOREIGN KEY FK_7A52C8DB1844E6B7');
        $this->addSql('ALTER TABLE oh_server_server_tag DROP FOREIGN KEY FK_7A52C8DBC3AE5AD7');
        $this->addSql('DROP TABLE oh_server_server_tag');
        $this->addSql('DROP TABLE oh_server_tag');
    }
}
