<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120162446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_character (id INT AUTO_INCREMENT NOT NULL, server_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(55) NOT NULL, status VARCHAR(10) NOT NULL, discord_uid VARCHAR(45) DEFAULT NULL, ingame_uid VARCHAR(45) DEFAULT NULL, INDEX IDX_F6683B341844E6B7 (server_id), INDEX IDX_F6683B34A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_hive (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, name VARCHAR(25) NOT NULL, status VARCHAR(10) NOT NULL, INDEX IDX_435F52BB73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_hive_member (hive_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_D9010094E9A48D12 (hive_id), INDEX IDX_D90100941136BE75 (character_id), PRIMARY KEY(hive_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_character ADD CONSTRAINT FK_F6683B341844E6B7 FOREIGN KEY (server_id) REFERENCES oh_server (id)');
        $this->addSql('ALTER TABLE oh_character ADD CONSTRAINT FK_F6683B34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE oh_hive ADD CONSTRAINT FK_435F52BB73154ED4 FOREIGN KEY (leader_id) REFERENCES oh_character (id)');
        $this->addSql('ALTER TABLE oh_hive_member ADD CONSTRAINT FK_D9010094E9A48D12 FOREIGN KEY (hive_id) REFERENCES oh_hive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_hive_member ADD CONSTRAINT FK_D90100941136BE75 FOREIGN KEY (character_id) REFERENCES oh_character (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_character DROP FOREIGN KEY FK_F6683B341844E6B7');
        $this->addSql('ALTER TABLE oh_character DROP FOREIGN KEY FK_F6683B34A76ED395');
        $this->addSql('ALTER TABLE oh_hive DROP FOREIGN KEY FK_435F52BB73154ED4');
        $this->addSql('ALTER TABLE oh_hive_member DROP FOREIGN KEY FK_D9010094E9A48D12');
        $this->addSql('ALTER TABLE oh_hive_member DROP FOREIGN KEY FK_D90100941136BE75');
        $this->addSql('DROP TABLE oh_character');
        $this->addSql('DROP TABLE oh_hive');
        $this->addSql('DROP TABLE oh_hive_member');
    }
}
