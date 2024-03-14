<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314082951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, list_step_id INT NOT NULL, date_step_start DATETIME DEFAULT NULL, date_step_stop DATETIME DEFAULT NULL, date_canceled DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_43B9FE3CA76ED395 (user_id), INDEX IDX_43B9FE3CAFFDC391 (list_step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CAFFDC391 FOREIGN KEY (list_step_id) REFERENCES step_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CA76ED395');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CAFFDC391');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE step');
    }
}
