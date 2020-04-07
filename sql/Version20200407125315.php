<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407125315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT UNSIGNED AUTO_INCREMENT NOT NULL, subscriber_id INT UNSIGNED DEFAULT NULL, supplier_id INT UNSIGNED DEFAULT NULL, price VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F52993987808B1AD (subscriber_id), INDEX IDX_F52993982ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT UNSIGNED AUTO_INCREMENT NOT NULL, ico VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_81398E092B9A6D10 (ico), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987808B1AD FOREIGN KEY (subscriber_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982ADD6D8C FOREIGN KEY (supplier_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987808B1AD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982ADD6D8C');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE customer');
    }
}
