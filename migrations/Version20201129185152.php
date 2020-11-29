<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129185152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appartment (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, number_of_rooms SMALLINT NOT NULL, image LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appartment_facility (appartment_id INT NOT NULL, facility_id INT NOT NULL, INDEX IDX_DD343EDD2714DC20 (appartment_id), INDEX IDX_DD343EDDA7014910 (facility_id), PRIMARY KEY(appartment_id, facility_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appartment_pricing (id INT AUTO_INCREMENT NOT NULL, id_appartment_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_5F5D50C6993C0D45 (id_appartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facility (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, total_price NUMERIC(10, 2) NOT NULL, INDEX IDX_42C8495579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_appartment (reservation_id INT NOT NULL, appartment_id INT NOT NULL, INDEX IDX_ADC9E444B83297E7 (reservation_id), INDEX IDX_ADC9E4442714DC20 (appartment_id), PRIMARY KEY(reservation_id, appartment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_pricing (id INT AUTO_INCREMENT NOT NULL, id_service_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_2A75FEAF48D62931 (id_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appartment_facility ADD CONSTRAINT FK_DD343EDD2714DC20 FOREIGN KEY (appartment_id) REFERENCES appartment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appartment_facility ADD CONSTRAINT FK_DD343EDDA7014910 FOREIGN KEY (facility_id) REFERENCES facility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appartment_pricing ADD CONSTRAINT FK_5F5D50C6993C0D45 FOREIGN KEY (id_appartment_id) REFERENCES appartment (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation_appartment ADD CONSTRAINT FK_ADC9E444B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_appartment ADD CONSTRAINT FK_ADC9E4442714DC20 FOREIGN KEY (appartment_id) REFERENCES appartment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_pricing ADD CONSTRAINT FK_2A75FEAF48D62931 FOREIGN KEY (id_service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appartment_facility DROP FOREIGN KEY FK_DD343EDD2714DC20');
        $this->addSql('ALTER TABLE appartment_pricing DROP FOREIGN KEY FK_5F5D50C6993C0D45');
        $this->addSql('ALTER TABLE reservation_appartment DROP FOREIGN KEY FK_ADC9E4442714DC20');
        $this->addSql('ALTER TABLE appartment_facility DROP FOREIGN KEY FK_DD343EDDA7014910');
        $this->addSql('ALTER TABLE reservation_appartment DROP FOREIGN KEY FK_ADC9E444B83297E7');
        $this->addSql('ALTER TABLE service_pricing DROP FOREIGN KEY FK_2A75FEAF48D62931');
        $this->addSql('DROP TABLE appartment');
        $this->addSql('DROP TABLE appartment_facility');
        $this->addSql('DROP TABLE appartment_pricing');
        $this->addSql('DROP TABLE facility');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_appartment');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_pricing');
    }
}
