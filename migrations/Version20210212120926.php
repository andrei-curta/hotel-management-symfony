<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212120926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_service (reservation_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_86082157B83297E7 (reservation_id), INDEX IDX_86082157ED5CA9E6 (service_id), PRIMARY KEY(reservation_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_service ADD CONSTRAINT FK_86082157B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_service ADD CONSTRAINT FK_86082157ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation_service');
    }
}
