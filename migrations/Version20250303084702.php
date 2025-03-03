<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303084702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pr_post_tag DROP FOREIGN KEY FK_F51EDD84BAD26311');
        $this->addSql('ALTER TABLE pr_post_tag DROP FOREIGN KEY FK_F51EDD844B89032C');
        $this->addSql('DROP TABLE pr_post_tag');
        $this->addSql('DROP TABLE pr_tag');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pr_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F51EDD844B89032C (post_id), INDEX IDX_F51EDD84BAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pr_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pr_post_tag ADD CONSTRAINT FK_F51EDD84BAD26311 FOREIGN KEY (tag_id) REFERENCES pr_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pr_post_tag ADD CONSTRAINT FK_F51EDD844B89032C FOREIGN KEY (post_id) REFERENCES pr_post (id) ON DELETE CASCADE');
    }
}
