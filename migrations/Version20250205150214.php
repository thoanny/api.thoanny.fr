<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205150214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_character_specialization (character_id INT NOT NULL, specialization_id INT NOT NULL, INDEX IDX_1FD556C91136BE75 (character_id), INDEX IDX_1FD556C9FA846217 (specialization_id), PRIMARY KEY(character_id, specialization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_character_specialization ADD CONSTRAINT FK_1FD556C91136BE75 FOREIGN KEY (character_id) REFERENCES oh_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_character_specialization ADD CONSTRAINT FK_1FD556C9FA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_character_specialization DROP FOREIGN KEY FK_1FD556C91136BE75');
        $this->addSql('ALTER TABLE oh_character_specialization DROP FOREIGN KEY FK_1FD556C9FA846217');
        $this->addSql('DROP TABLE oh_character_specialization');
    }
}
