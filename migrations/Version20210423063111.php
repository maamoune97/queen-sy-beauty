<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423063111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE home_page_collection_preview (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, UNIQUE INDEX UNIQ_2EB906B712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE home_page_collection_preview ADD CONSTRAINT FK_2EB906B712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD home_page_collection_preview_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD42B78125 FOREIGN KEY (home_page_collection_preview_id) REFERENCES home_page_collection_preview (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD42B78125 ON product (home_page_collection_preview_id)');
        $this->addSql('ALTER TABLE sub_category ADD home_page_collection_preview_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79842B78125 FOREIGN KEY (home_page_collection_preview_id) REFERENCES home_page_collection_preview (id)');
        $this->addSql('CREATE INDEX IDX_BCE3F79842B78125 ON sub_category (home_page_collection_preview_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD42B78125');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79842B78125');
        $this->addSql('DROP TABLE home_page_collection_preview');
        $this->addSql('DROP INDEX IDX_D34A04AD42B78125 ON product');
        $this->addSql('ALTER TABLE product DROP home_page_collection_preview_id');
        $this->addSql('DROP INDEX IDX_BCE3F79842B78125 ON sub_category');
        $this->addSql('ALTER TABLE sub_category DROP home_page_collection_preview_id');
    }
}
