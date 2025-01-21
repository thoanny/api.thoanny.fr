<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120160622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_specialization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(55) DEFAULT NULL, description LONGTEXT DEFAULT NULL, levels JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_specialization_scenario (specialization_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_FBB277BDFA846217 (specialization_id), INDEX IDX_FBB277BDE04E49DF (scenario_id), PRIMARY KEY(specialization_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_specialization_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_specialization_group_specialization (specialization_group_id INT NOT NULL, specialization_id INT NOT NULL, INDEX IDX_7A167BA2BDA0B58F (specialization_group_id), INDEX IDX_7A167BA2FA846217 (specialization_id), PRIMARY KEY(specialization_group_id, specialization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_specialization_scenario ADD CONSTRAINT FK_FBB277BDFA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_scenario ADD CONSTRAINT FK_FBB277BDE04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization ADD CONSTRAINT FK_7A167BA2BDA0B58F FOREIGN KEY (specialization_group_id) REFERENCES oh_specialization_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization ADD CONSTRAINT FK_7A167BA2FA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_specialization_scenario DROP FOREIGN KEY FK_FBB277BDFA846217');
        $this->addSql('ALTER TABLE oh_specialization_scenario DROP FOREIGN KEY FK_FBB277BDE04E49DF');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization DROP FOREIGN KEY FK_7A167BA2BDA0B58F');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization DROP FOREIGN KEY FK_7A167BA2FA846217');
        $this->addSql('DROP TABLE oh_specialization');
        $this->addSql('DROP TABLE oh_specialization_scenario');
        $this->addSql('DROP TABLE oh_specialization_group');
        $this->addSql('DROP TABLE oh_specialization_group_specialization');
    }
}
