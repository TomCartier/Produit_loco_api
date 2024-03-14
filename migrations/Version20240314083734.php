<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314083734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_product (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cart_id INT NOT NULL, step_id INT NOT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_F5299398A76ED395 (user_id), UNIQUE INDEX UNIQ_F52993981AD5CDBF (cart_id), UNIQUE INDEX UNIQ_F529939873B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939873B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE cart ADD cart_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B725EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id)');
        $this->addSql('CREATE INDEX IDX_BA388B725EE16A8 ON cart (cart_product_id)');
        $this->addSql('ALTER TABLE product ADD cart_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD25EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD25EE16A8 ON product (cart_product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B725EE16A8');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD25EE16A8');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981AD5CDBF');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939873B21E9C');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP INDEX IDX_BA388B725EE16A8 ON cart');
        $this->addSql('ALTER TABLE cart DROP cart_product_id');
        $this->addSql('DROP INDEX IDX_D34A04AD25EE16A8 ON product');
        $this->addSql('ALTER TABLE product DROP cart_product_id');
    }
}
