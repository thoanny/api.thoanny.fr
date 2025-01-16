<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115181703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, how_to_get LONGTEXT DEFAULT NULL, rarity VARCHAR(10) NOT NULL, weight INT DEFAULT NULL, INDEX IDX_8029CC5D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_recipe (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, workshop_id INT DEFAULT NULL, quantity INT NOT NULL, duration INT DEFAULT NULL, INDEX IDX_D80A681F126F525E (item_id), INDEX IDX_D80A681F1FDCE57C (workshop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, item_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_B70C1BB659D8A214 (recipe_id), INDEX IDX_B70C1BB6126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_scenario (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_server (id INT AUTO_INCREMENT NOT NULL, scenario_id INT NOT NULL, difficulty VARCHAR(10) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', closed TINYINT(1) NOT NULL, INDEX IDX_58EF0CDEE04E49DF (scenario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_item ADD CONSTRAINT FK_8029CC5D12469DE2 FOREIGN KEY (category_id) REFERENCES oh_item_category (id)');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id)');
        $this->addSql('ALTER TABLE oh_recipe ADD CONSTRAINT FK_D80A681F1FDCE57C FOREIGN KEY (workshop_id) REFERENCES oh_item (id)');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB659D8A214 FOREIGN KEY (recipe_id) REFERENCES oh_recipe (id)');
        $this->addSql('ALTER TABLE oh_recipe_ingredient ADD CONSTRAINT FK_B70C1BB6126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id)');
        $this->addSql('ALTER TABLE oh_server ADD CONSTRAINT FK_58EF0CDEE04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_item DROP FOREIGN KEY FK_8029CC5D12469DE2');
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F126F525E');
        $this->addSql('ALTER TABLE oh_recipe DROP FOREIGN KEY FK_D80A681F1FDCE57C');
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB659D8A214');
        $this->addSql('ALTER TABLE oh_recipe_ingredient DROP FOREIGN KEY FK_B70C1BB6126F525E');
        $this->addSql('ALTER TABLE oh_server DROP FOREIGN KEY FK_58EF0CDEE04E49DF');
        $this->addSql('DROP TABLE oh_item');
        $this->addSql('DROP TABLE oh_item_category');
        $this->addSql('DROP TABLE oh_recipe');
        $this->addSql('DROP TABLE oh_recipe_ingredient');
        $this->addSql('DROP TABLE oh_scenario');
        $this->addSql('DROP TABLE oh_server');
    }
}
