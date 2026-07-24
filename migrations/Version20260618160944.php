<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260618160944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_character DROP FOREIGN KEY FK_F6683B34A76ED395');
        $this->addSql('ALTER TABLE oh_character DROP FOREIGN KEY FK_F6683B341844E6B7');
        $this->addSql('ALTER TABLE oh_character_specialization DROP FOREIGN KEY FK_1FD556C91136BE75');
        $this->addSql('ALTER TABLE oh_character_specialization DROP FOREIGN KEY FK_1FD556C9FA846217');
        $this->addSql('ALTER TABLE oh_hive DROP FOREIGN KEY FK_435F52BB73154ED4');
        $this->addSql('ALTER TABLE oh_hive_member DROP FOREIGN KEY FK_D90100941136BE75');
        $this->addSql('ALTER TABLE oh_hive_member DROP FOREIGN KEY FK_D9010094E9A48D12');
        $this->addSql('ALTER TABLE oh_item DROP FOREIGN KEY FK_8029CC5D12469DE2');
        $this->addSql('ALTER TABLE oh_item_scenario DROP FOREIGN KEY FK_FA041176126F525E');
        $this->addSql('ALTER TABLE oh_item_scenario DROP FOREIGN KEY FK_FA041176E04E49DF');
        $this->addSql('ALTER TABLE oh_memetic DROP FOREIGN KEY FK_44A5D2DC12469DE2');
        $this->addSql('ALTER TABLE oh_memetic DROP FOREIGN KEY FK_44A5D2DC727ACA70');
        $this->addSql('ALTER TABLE oh_memetic_item DROP FOREIGN KEY FK_C9C0A3C5F705EB51');
        $this->addSql('ALTER TABLE oh_memetic_item DROP FOREIGN KEY FK_C9C0A3C5126F525E');
        $this->addSql('ALTER TABLE oh_memetic_scenario DROP FOREIGN KEY FK_27D4FA47F705EB51');
        $this->addSql('ALTER TABLE oh_memetic_scenario DROP FOREIGN KEY FK_27D4FA47E04E49DF');
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F126F525E');
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F1FDCE57C');
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB6126F525E');
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB659D8A214');
        $this->addSql('ALTER TABLE oh_server DROP FOREIGN KEY FK_58EF0CDEE04E49DF');
        $this->addSql('ALTER TABLE oh_server_server_tag DROP FOREIGN KEY FK_7A52C8DB1844E6B7');
        $this->addSql('ALTER TABLE oh_server_server_tag DROP FOREIGN KEY FK_7A52C8DBC3AE5AD7');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization DROP FOREIGN KEY FK_7A167BA2FA846217');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization DROP FOREIGN KEY FK_7A167BA2BDA0B58F');
        $this->addSql('ALTER TABLE oh_specialization_scenario DROP FOREIGN KEY FK_FBB277BDE04E49DF');
        $this->addSql('ALTER TABLE oh_specialization_scenario DROP FOREIGN KEY FK_FBB277BDFA846217');
        $this->addSql('ALTER TABLE pr_post DROP FOREIGN KEY FK_F663481412469DE2');
        $this->addSql('DROP TABLE oh_character');
        $this->addSql('DROP TABLE oh_character_specialization');
        $this->addSql('DROP TABLE oh_event');
        $this->addSql('DROP TABLE oh_hive');
        $this->addSql('DROP TABLE oh_hive_member');
        $this->addSql('DROP TABLE oh_item');
        $this->addSql('DROP TABLE oh_item_category');
        $this->addSql('DROP TABLE oh_item_scenario');
        $this->addSql('DROP TABLE oh_memetic');
        $this->addSql('DROP TABLE oh_memetic_category');
        $this->addSql('DROP TABLE oh_memetic_item');
        $this->addSql('DROP TABLE oh_memetic_scenario');
        $this->addSql('DROP TABLE oh_recipe');
        $this->addSql('DROP TABLE oh_recipe_ingredient');
        $this->addSql('DROP TABLE oh_scenario');
        $this->addSql('DROP TABLE oh_server');
        $this->addSql('DROP TABLE oh_server_server_tag');
        $this->addSql('DROP TABLE oh_server_tag');
        $this->addSql('DROP TABLE oh_specialization');
        $this->addSql('DROP TABLE oh_specialization_group');
        $this->addSql('DROP TABLE oh_specialization_group_specialization');
        $this->addSql('DROP TABLE oh_specialization_scenario');
        $this->addSql('DROP TABLE pr_category');
        $this->addSql('DROP TABLE pr_post');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_character (id INT AUTO_INCREMENT NOT NULL, server_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, discord_uid VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ingame_uid VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, token VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F6683B34A76ED395 (user_id), INDEX IDX_F6683B341844E6B7 (server_id), UNIQUE INDEX UNIQ_F6683B345F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_character_specialization (character_id INT NOT NULL, specialization_id INT NOT NULL, INDEX IDX_1FD556C9FA846217 (specialization_id), INDEX IDX_1FD556C91136BE75 (character_id), PRIMARY KEY(character_id, specialization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', all_day TINYINT(1) NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_hive (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, name VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, token VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_435F52BB73154ED4 (leader_id), UNIQUE INDEX UNIQ_435F52BB5F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_hive_member (hive_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_D90100941136BE75 (character_id), INDEX IDX_D9010094E9A48D12 (hive_id), PRIMARY KEY(hive_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, how_to_get LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rarity VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, weight INT DEFAULT NULL, icon VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8029CC5D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_item_scenario (item_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_FA041176126F525E (item_id), INDEX IDX_FA041176E04E49DF (scenario_id), PRIMARY KEY(item_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_memetic (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_44A5D2DC727ACA70 (parent_id), INDEX IDX_44A5D2DC12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_memetic_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_memetic_item (memetic_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_C9C0A3C5F705EB51 (memetic_id), INDEX IDX_C9C0A3C5126F525E (item_id), PRIMARY KEY(memetic_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_memetic_scenario (memetic_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_27D4FA47F705EB51 (memetic_id), INDEX IDX_27D4FA47E04E49DF (scenario_id), PRIMARY KEY(memetic_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_recipe (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, workshop_id INT DEFAULT NULL, quantity INT NOT NULL, duration INT DEFAULT NULL, INDEX IDX_D80A681F1FDCE57C (workshop_id), INDEX IDX_D80A681F126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, item_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B70C1BB659D8A214 (recipe_id), INDEX IDX_B70C1BB6126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_scenario (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_server (id INT AUTO_INCREMENT NOT NULL, scenario_id INT NOT NULL, difficulty VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', closed TINYINT(1) NOT NULL, name VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_58EF0CDE5E237E06 (name), INDEX IDX_58EF0CDEE04E49DF (scenario_id), UNIQUE INDEX UNIQ_58EF0CDE989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_server_server_tag (server_id INT NOT NULL, server_tag_id INT NOT NULL, INDEX IDX_7A52C8DBC3AE5AD7 (server_tag_id), INDEX IDX_7A52C8DB1844E6B7 (server_id), PRIMARY KEY(server_id, server_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_server_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_specialization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, levels JSON DEFAULT NULL, icon VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_specialization_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_specialization_group_specialization (specialization_group_id INT NOT NULL, specialization_id INT NOT NULL, INDEX IDX_7A167BA2BDA0B58F (specialization_group_id), INDEX IDX_7A167BA2FA846217 (specialization_id), PRIMARY KEY(specialization_group_id, specialization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oh_specialization_scenario (specialization_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_FBB277BDFA846217 (specialization_id), INDEX IDX_FBB277BDE04E49DF (scenario_id), PRIMARY KEY(specialization_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pr_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pr_post (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, source VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, thumbnail VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, uid VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_F6634814539B0606 (uid), INDEX IDX_F663481412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oh_character ADD CONSTRAINT FK_F6683B34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE oh_character ADD CONSTRAINT FK_F6683B341844E6B7 FOREIGN KEY (server_id) REFERENCES oh_server (id)');
        $this->addSql('ALTER TABLE oh_character_specialization ADD CONSTRAINT FK_1FD556C91136BE75 FOREIGN KEY (character_id) REFERENCES oh_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_character_specialization ADD CONSTRAINT FK_1FD556C9FA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_hive ADD CONSTRAINT FK_435F52BB73154ED4 FOREIGN KEY (leader_id) REFERENCES oh_character (id)');
        $this->addSql('ALTER TABLE oh_hive_member ADD CONSTRAINT FK_D90100941136BE75 FOREIGN KEY (character_id) REFERENCES oh_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_hive_member ADD CONSTRAINT FK_D9010094E9A48D12 FOREIGN KEY (hive_id) REFERENCES oh_hive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_item ADD CONSTRAINT FK_8029CC5D12469DE2 FOREIGN KEY (category_id) REFERENCES oh_item_category (id)');
        $this->addSql('ALTER TABLE oh_item_scenario ADD CONSTRAINT FK_FA041176126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_item_scenario ADD CONSTRAINT FK_FA041176E04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic ADD CONSTRAINT FK_44A5D2DC12469DE2 FOREIGN KEY (category_id) REFERENCES oh_memetic_category (id)');
        $this->addSql('ALTER TABLE oh_memetic ADD CONSTRAINT FK_44A5D2DC727ACA70 FOREIGN KEY (parent_id) REFERENCES oh_memetic (id)');
        $this->addSql('ALTER TABLE oh_memetic_item ADD CONSTRAINT FK_C9C0A3C5F705EB51 FOREIGN KEY (memetic_id) REFERENCES oh_memetic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_item ADD CONSTRAINT FK_C9C0A3C5126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_scenario ADD CONSTRAINT FK_27D4FA47F705EB51 FOREIGN KEY (memetic_id) REFERENCES oh_memetic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_scenario ADD CONSTRAINT FK_27D4FA47E04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F1FDCE57C FOREIGN KEY (workshop_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB6126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB659D8A214 FOREIGN KEY (recipe_id) REFERENCES oh_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_server ADD CONSTRAINT FK_58EF0CDEE04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id)');
        $this->addSql('ALTER TABLE oh_server_server_tag ADD CONSTRAINT FK_7A52C8DB1844E6B7 FOREIGN KEY (server_id) REFERENCES oh_server (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_server_server_tag ADD CONSTRAINT FK_7A52C8DBC3AE5AD7 FOREIGN KEY (server_tag_id) REFERENCES oh_server_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization ADD CONSTRAINT FK_7A167BA2FA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_group_specialization ADD CONSTRAINT FK_7A167BA2BDA0B58F FOREIGN KEY (specialization_group_id) REFERENCES oh_specialization_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_scenario ADD CONSTRAINT FK_FBB277BDE04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_specialization_scenario ADD CONSTRAINT FK_FBB277BDFA846217 FOREIGN KEY (specialization_id) REFERENCES oh_specialization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pr_post ADD CONSTRAINT FK_F663481412469DE2 FOREIGN KEY (category_id) REFERENCES pr_category (id)');
    }
}
