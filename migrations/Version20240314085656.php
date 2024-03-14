<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314085656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B725EE16A8');
        $this->addSql('DROP INDEX IDX_BA388B725EE16A8 ON cart');
        $this->addSql('ALTER TABLE cart DROP cart_product_id');
        $this->addSql('ALTER TABLE cart_product ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_product ADD CONSTRAINT FK_2890CCAA1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_2890CCAA1AD5CDBF ON cart_product (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD cart_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B725EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id)');
        $this->addSql('CREATE INDEX IDX_BA388B725EE16A8 ON cart (cart_product_id)');
        $this->addSql('ALTER TABLE cart_product DROP FOREIGN KEY FK_2890CCAA1AD5CDBF');
        $this->addSql('DROP INDEX IDX_2890CCAA1AD5CDBF ON cart_product');
        $this->addSql('ALTER TABLE cart_product DROP cart_id');
    }
}
