<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303085809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pr_post DROP FOREIGN KEY FK_F66348145E7AA58C');
        $this->addSql('ALTER TABLE pr_issue DROP FOREIGN KEY FK_9BD2E1FA12469DE2');
        $this->addSql('DROP TABLE pr_issue');
        $this->addSql('DROP INDEX IDX_F66348145E7AA58C ON pr_post');
        $this->addSql('ALTER TABLE pr_post DROP issue_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pr_issue (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9BD2E1FA12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pr_issue ADD CONSTRAINT FK_9BD2E1FA12469DE2 FOREIGN KEY (category_id) REFERENCES pr_category (id)');
        $this->addSql('ALTER TABLE pr_post ADD issue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pr_post ADD CONSTRAINT FK_F66348145E7AA58C FOREIGN KEY (issue_id) REFERENCES pr_issue (id)');
        $this->addSql('CREATE INDEX IDX_F66348145E7AA58C ON pr_post (issue_id)');
    }
}
