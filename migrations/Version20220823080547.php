<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823080547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, short_description LONGTEXT DEFAULT NULL, street_number INT NOT NULL, adress LONGTEXT NOT NULL, city VARCHAR(150) NOT NULL, isactive TINYINT(1) NOT NULL, phone VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission ADD hall_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('CREATE INDEX IDX_E04992AA52AFCFD6 ON permission (hall_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AA52AFCFD6');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP INDEX IDX_E04992AA52AFCFD6 ON permission');
        $this->addSql('ALTER TABLE permission DROP hall_id');
    }
}
