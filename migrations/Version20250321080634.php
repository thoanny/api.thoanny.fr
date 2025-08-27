<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321080634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_folder (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_50DB9313A977936C (tree_root), INDEX IDX_50DB9313727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_folder ADD CONSTRAINT FK_50DB9313A977936C FOREIGN KEY (tree_root) REFERENCES media_folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_folder ADD CONSTRAINT FK_50DB9313727ACA70 FOREIGN KEY (parent_id) REFERENCES media_folder (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_folder DROP FOREIGN KEY FK_50DB9313A977936C');
        $this->addSql('ALTER TABLE media_folder DROP FOREIGN KEY FK_50DB9313727ACA70');
        $this->addSql('DROP TABLE media_folder');
    }
}
