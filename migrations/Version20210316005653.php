<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316005653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, registered_customer_id INT DEFAULT NULL, unregistered_customer_id INT DEFAULT NULL, status INT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F529939851834092 (registered_customer_id), UNIQUE INDEX UNIQ_F5299398FF759F2C (unregistered_customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unregistered_customer (id INT AUTO_INCREMENT NOT NULL, l_name VARCHAR(100) NOT NULL, f_name VARCHAR(100) NOT NULL, phone_number VARCHAR(20) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939851834092 FOREIGN KEY (registered_customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398FF759F2C FOREIGN KEY (unregistered_customer_id) REFERENCES unregistered_customer (id)');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398FF759F2C');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE unregistered_customer');
        $this->addSql('ALTER TABLE `user` DROP phone_number');
    }
}
