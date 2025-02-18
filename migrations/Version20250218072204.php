<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218072204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pr_issue ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE pr_issue ADD CONSTRAINT FK_9BD2E1FA12469DE2 FOREIGN KEY (category_id) REFERENCES pr_category (id)');
        $this->addSql('CREATE INDEX IDX_9BD2E1FA12469DE2 ON pr_issue (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pr_issue DROP FOREIGN KEY FK_9BD2E1FA12469DE2');
        $this->addSql('DROP INDEX IDX_9BD2E1FA12469DE2 ON pr_issue');
        $this->addSql('ALTER TABLE pr_issue DROP category_id');
    }
}
