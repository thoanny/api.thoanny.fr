<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260818104817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `vestigia_account` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nickname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3B14ED83A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `vestigia_account_goal` (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', status VARCHAR(15) NOT NULL, INDEX IDX_54372C069B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `vestigia_character` (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, iteration INT NOT NULL, dead TINYINT(1) NOT NULL, hp_min INT NOT NULL, hp_max INT NOT NULL, atk INT NOT NULL, def INT NOT NULL, ap_min INT NOT NULL, ap_max INT NOT NULL, lvl INT NOT NULL, xp INT NOT NULL, avatar_body VARCHAR(5) NOT NULL, avatar_head VARCHAR(5) NOT NULL, avatar_face VARCHAR(5) NOT NULL, avatar_hairs VARCHAR(5) DEFAULT NULL, avatar_accessory VARCHAR(5) DEFAULT NULL, INDEX IDX_150C2E779B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `vestigia_goal` (id INT AUTO_INCREMENT NOT NULL, reward_item_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(10) NOT NULL, duration INT NOT NULL, steps INT NOT NULL, reward_quantity INT DEFAULT NULL, INDEX IDX_AD45C86FF8D8AFA6 (reward_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `vestigia_inventory_item` (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, account_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_2AD47511126F525E (item_id), INDEX IDX_2AD475119B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `vestigia_account` ADD CONSTRAINT FK_3B14ED83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `vestigia_account_goal` ADD CONSTRAINT FK_54372C069B6B5FBA FOREIGN KEY (account_id) REFERENCES `vestigia_account` (id)');
        $this->addSql('ALTER TABLE `vestigia_character` ADD CONSTRAINT FK_150C2E779B6B5FBA FOREIGN KEY (account_id) REFERENCES `vestigia_account` (id)');
        $this->addSql('ALTER TABLE `vestigia_goal` ADD CONSTRAINT FK_AD45C86FF8D8AFA6 FOREIGN KEY (reward_item_id) REFERENCES vestigia_item (id)');
        $this->addSql('ALTER TABLE `vestigia_inventory_item` ADD CONSTRAINT FK_2AD47511126F525E FOREIGN KEY (item_id) REFERENCES vestigia_item (id)');
        $this->addSql('ALTER TABLE `vestigia_inventory_item` ADD CONSTRAINT FK_2AD475119B6B5FBA FOREIGN KEY (account_id) REFERENCES `vestigia_account` (id)');
        $this->addSql('DROP TABLE item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, rarity VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, stackable TINYINT(1) NOT NULL, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `vestigia_account` DROP FOREIGN KEY FK_3B14ED83A76ED395');
        $this->addSql('ALTER TABLE `vestigia_account_goal` DROP FOREIGN KEY FK_54372C069B6B5FBA');
        $this->addSql('ALTER TABLE `vestigia_character` DROP FOREIGN KEY FK_150C2E779B6B5FBA');
        $this->addSql('ALTER TABLE `vestigia_goal` DROP FOREIGN KEY FK_AD45C86FF8D8AFA6');
        $this->addSql('ALTER TABLE `vestigia_inventory_item` DROP FOREIGN KEY FK_2AD47511126F525E');
        $this->addSql('ALTER TABLE `vestigia_inventory_item` DROP FOREIGN KEY FK_2AD475119B6B5FBA');
        $this->addSql('DROP TABLE `vestigia_account`');
        $this->addSql('DROP TABLE `vestigia_account_goal`');
        $this->addSql('DROP TABLE `vestigia_character`');
        $this->addSql('DROP TABLE `vestigia_goal`');
        $this->addSql('DROP TABLE `vestigia_inventory_item`');
    }
}
