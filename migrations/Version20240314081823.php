<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314081823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris_user (favoris_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3E144C2E51E8871B (favoris_id), INDEX IDX_3E144C2EA76ED395 (user_id), PRIMARY KEY(favoris_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, farm_id INT DEFAULT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(15) DEFAULT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(50) NOT NULL, post_code VARCHAR(5) NOT NULL, country VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_8D93D64965FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favoris_user ADD CONSTRAINT FK_3E144C2E51E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris_user ADD CONSTRAINT FK_3E144C2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64965FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris_user DROP FOREIGN KEY FK_3E144C2E51E8871B');
        $this->addSql('ALTER TABLE favoris_user DROP FOREIGN KEY FK_3E144C2EA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64965FCFA0D');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE favoris_user');
        $this->addSql('DROP TABLE user');
    }
}
