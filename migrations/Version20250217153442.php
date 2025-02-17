<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217153442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pr_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pr_issue (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pr_post (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, issue_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, source VARCHAR(55) DEFAULT NULL, link VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(45) NOT NULL, description LONGTEXT DEFAULT NULL, lvl INT DEFAULT NULL, uid VARCHAR(40) NOT NULL, INDEX IDX_F663481412469DE2 (category_id), INDEX IDX_F66348145E7AA58C (issue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pr_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F51EDD844B89032C (post_id), INDEX IDX_F51EDD84BAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pr_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pr_post ADD CONSTRAINT FK_F663481412469DE2 FOREIGN KEY (category_id) REFERENCES pr_category (id)');
        $this->addSql('ALTER TABLE pr_post ADD CONSTRAINT FK_F66348145E7AA58C FOREIGN KEY (issue_id) REFERENCES pr_issue (id)');
        $this->addSql('ALTER TABLE pr_post_tag ADD CONSTRAINT FK_F51EDD844B89032C FOREIGN KEY (post_id) REFERENCES pr_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pr_post_tag ADD CONSTRAINT FK_F51EDD84BAD26311 FOREIGN KEY (tag_id) REFERENCES pr_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pr_post DROP FOREIGN KEY FK_F663481412469DE2');
        $this->addSql('ALTER TABLE pr_post DROP FOREIGN KEY FK_F66348145E7AA58C');
        $this->addSql('ALTER TABLE pr_post_tag DROP FOREIGN KEY FK_F51EDD844B89032C');
        $this->addSql('ALTER TABLE pr_post_tag DROP FOREIGN KEY FK_F51EDD84BAD26311');
        $this->addSql('DROP TABLE pr_category');
        $this->addSql('DROP TABLE pr_issue');
        $this->addSql('DROP TABLE pr_post');
        $this->addSql('DROP TABLE pr_post_tag');
        $this->addSql('DROP TABLE pr_tag');
    }
}
