<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411122252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_option (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, name VARCHAR(30) DEFAULT NULL, type VARCHAR(10) DEFAULT NULL, INDEX IDX_38FA41144584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_option_field (id INT AUTO_INCREMENT NOT NULL, product_option_id INT NOT NULL, name VARCHAR(30) NOT NULL, added_price INT NOT NULL, INDEX IDX_EFBADA5BC964ABE2 (product_option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA41144584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_option_field ADD CONSTRAINT FK_EFBADA5BC964ABE2 FOREIGN KEY (product_option_id) REFERENCES product_option (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option_field DROP FOREIGN KEY FK_EFBADA5BC964ABE2');
        $this->addSql('DROP TABLE product_option');
        $this->addSql('DROP TABLE product_option_field');
    }
}
