<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250827064737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content JSON DEFAULT NULL, status VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', seo_title VARCHAR(255) DEFAULT NULL, seo_description LONGTEXT DEFAULT NULL, seo_keywords VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_caption VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5A8A6C8D989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_5ACE3AF04B89032C (post_id), INDEX IDX_5ACE3AF0BAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT FK_5ACE3AF04B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_tag ADD CONSTRAINT FK_5ACE3AF0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_file DROP FOREIGN KEY FK_4FD8E9C3162CB942');
        $this->addSql('ALTER TABLE media_folder DROP FOREIGN KEY FK_50DB9313A977936C');
        $this->addSql('ALTER TABLE media_folder DROP FOREIGN KEY FK_50DB9313727ACA70');
        $this->addSql('DROP TABLE media_file');
        $this->addSql('DROP TABLE media_folder');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_file (id INT AUTO_INCREMENT NOT NULL, folder_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, size INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4FD8E9C3162CB942 (folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE media_folder (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_50DB9313727ACA70 (parent_id), INDEX IDX_50DB9313A977936C (tree_root), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE media_file ADD CONSTRAINT FK_4FD8E9C3162CB942 FOREIGN KEY (folder_id) REFERENCES media_folder (id)');
        $this->addSql('ALTER TABLE media_folder ADD CONSTRAINT FK_50DB9313A977936C FOREIGN KEY (tree_root) REFERENCES media_folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_folder ADD CONSTRAINT FK_50DB9313727ACA70 FOREIGN KEY (parent_id) REFERENCES media_folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A1906012469DE2');
        $this->addSql('ALTER TABLE post_tag DROP FOREIGN KEY FK_5ACE3AF04B89032C');
        $this->addSql('ALTER TABLE post_tag DROP FOREIGN KEY FK_5ACE3AF0BAD26311');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE post_tag');
        $this->addSql('DROP TABLE tag');
    }
}
