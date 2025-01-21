<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120164110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oh_memetic (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, na�me VARCHAR(55) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_44A5D2DC12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_memetic_scenario (memetic_id INT NOT NULL, scenario_id INT NOT NULL, INDEX IDX_27D4FA47F705EB51 (memetic_id), INDEX IDX_27D4FA47E04E49DF (scenario_id), PRIMARY KEY(memetic_id, scenario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_memetic_item (memetic_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_C9C0A3C5F705EB51 (memetic_id), INDEX IDX_C9C0A3C5126F525E (item_id), PRIMARY KEY(memetic_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oh_memetic_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oh_memetic ADD CONSTRAINT FK_44A5D2DC12469DE2 FOREIGN KEY (category_id) REFERENCES oh_memetic_category (id)');
        $this->addSql('ALTER TABLE oh_memetic_scenario ADD CONSTRAINT FK_27D4FA47F705EB51 FOREIGN KEY (memetic_id) REFERENCES oh_memetic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_scenario ADD CONSTRAINT FK_27D4FA47E04E49DF FOREIGN KEY (scenario_id) REFERENCES oh_scenario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_item ADD CONSTRAINT FK_C9C0A3C5F705EB51 FOREIGN KEY (memetic_id) REFERENCES oh_memetic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oh_memetic_item ADD CONSTRAINT FK_C9C0A3C5126F525E FOREIGN KEY (item_id) REFERENCES oh_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oh_memetic DROP FOREIGN KEY FK_44A5D2DC12469DE2');
        $this->addSql('ALTER TABLE oh_memetic_scenario DROP FOREIGN KEY FK_27D4FA47F705EB51');
        $this->addSql('ALTER TABLE oh_memetic_scenario DROP FOREIGN KEY FK_27D4FA47E04E49DF');
        $this->addSql('ALTER TABLE oh_memetic_item DROP FOREIGN KEY FK_C9C0A3C5F705EB51');
        $this->addSql('ALTER TABLE oh_memetic_item DROP FOREIGN KEY FK_C9C0A3C5126F525E');
        $this->addSql('DROP TABLE oh_memetic');
        $this->addSql('DROP TABLE oh_memetic_scenario');
        $this->addSql('DROP TABLE oh_memetic_item');
        $this->addSql('DROP TABLE oh_memetic_category');
    }
}
