<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402113624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, registered_customer_id INT DEFAULT NULL, unregistered_customer_id INT DEFAULT NULL, status INT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, INDEX IDX_F529939851834092 (registered_customer_id), UNIQUE INDEX UNIQ_F5299398FF759F2C (unregistered_customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, sub_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, cover_image VARCHAR(255) NOT NULL, visible TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_D34A04ADF7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) DEFAULT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_pack (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, command_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_1A367C824584665A (product_id), INDEX IDX_1A367C8233E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unregistered_customer (id INT AUTO_INCREMENT NOT NULL, l_name VARCHAR(100) NOT NULL, f_name VARCHAR(100) NOT NULL, phone_number VARCHAR(20) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, l_name VARCHAR(100) NOT NULL, f_name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, phone_number VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939851834092 FOREIGN KEY (registered_customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398FF759F2C FOREIGN KEY (unregistered_customer_id) REFERENCES unregistered_customer (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_pack ADD CONSTRAINT FK_1A367C824584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_pack ADD CONSTRAINT FK_1A367C8233E1689A FOREIGN KEY (command_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE product_pack DROP FOREIGN KEY FK_1A367C8233E1689A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_pack DROP FOREIGN KEY FK_1A367C824584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF7BFE87C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398FF759F2C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939851834092');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_pack');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE unregistered_customer');
        $this->addSql('DROP TABLE `user`');
    }
}
