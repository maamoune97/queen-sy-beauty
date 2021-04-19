<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417230805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_pack_product_option_field (product_pack_id INT NOT NULL, product_option_field_id INT NOT NULL, INDEX IDX_CC471F9C8C0A9A7 (product_pack_id), INDEX IDX_CC471F956CB7389 (product_option_field_id), PRIMARY KEY(product_pack_id, product_option_field_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_pack_product_option_field ADD CONSTRAINT FK_CC471F9C8C0A9A7 FOREIGN KEY (product_pack_id) REFERENCES product_pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_pack_product_option_field ADD CONSTRAINT FK_CC471F956CB7389 FOREIGN KEY (product_option_field_id) REFERENCES product_option_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD payment_mode SMALLINT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_pack_product_option_field');
        $this->addSql('ALTER TABLE `order` DROP payment_mode');
    }
}
