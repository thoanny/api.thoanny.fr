<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260821145523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vestigia_account_goal ADD goal_id INT NOT NULL');
        $this->addSql('ALTER TABLE vestigia_account_goal ADD CONSTRAINT FK_54372C06667D1AFE FOREIGN KEY (goal_id) REFERENCES `vestigia_goal` (id)');
        $this->addSql('CREATE INDEX IDX_54372C06667D1AFE ON vestigia_account_goal (goal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `vestigia_account_goal` DROP FOREIGN KEY FK_54372C06667D1AFE');
        $this->addSql('DROP INDEX IDX_54372C06667D1AFE ON `vestigia_account_goal`');
        $this->addSql('ALTER TABLE `vestigia_account_goal` DROP goal_id');
    }
}
