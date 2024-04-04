<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222152516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_497DD6344584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farm (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, post_code VARCHAR(5) NOT NULL, country VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE open_hours (id INT AUTO_INCREMENT NOT NULL, farm_id INT NOT NULL, day VARCHAR(50) NOT NULL, start_am TIME DEFAULT NULL, end_am TIME DEFAULT NULL, start_pm TIME DEFAULT NULL, end_pm TIME DEFAULT NULL, INDEX IDX_C1A79D8B65FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, farm_id INT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, picture LONGBLOB DEFAULT NULL, price INT NOT NULL, stock INT NOT NULL, creation_date DATE NOT NULL, INDEX IDX_D34A04AD65FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6344584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE open_hours ADD CONSTRAINT FK_C1A79D8B65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6344584665A');
        $this->addSql('ALTER TABLE open_hours DROP FOREIGN KEY FK_C1A79D8B65FCFA0D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD65FCFA0D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE farm');
        $this->addSql('DROP TABLE open_hours');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE step_list');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
