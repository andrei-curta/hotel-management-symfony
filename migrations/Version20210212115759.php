<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212115759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE service_pricing');
        $this->addSql('ALTER TABLE service ADD price NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_pricing (id INT AUTO_INCREMENT NOT NULL, id_service_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_2A75FEAF48D62931 (id_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_pricing ADD CONSTRAINT FK_2A75FEAF48D62931 FOREIGN KEY (id_service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service DROP price');
    }
}
