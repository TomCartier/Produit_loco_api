<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314084934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD25EE16A8');
        $this->addSql('DROP INDEX IDX_D34A04AD25EE16A8 ON product');
        $this->addSql('ALTER TABLE product DROP cart_product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD cart_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD25EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD25EE16A8 ON product (cart_product_id)');
    }
}
