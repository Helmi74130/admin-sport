<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825105719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, name VARCHAR(150) NOT NULL, short_description LONGTEXT DEFAULT NULL, street_number INT NOT NULL, adress LONGTEXT NOT NULL, city VARCHAR(150) NOT NULL, isactive TINYINT(1) NOT NULL, phone VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, INDEX IDX_1B8FA83F73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(100) NOT NULL, mail VARCHAR(50) NOT NULL, city VARCHAR(80) NOT NULL, phone VARCHAR(15) NOT NULL, commercial_phone VARCHAR(15) DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, is_sell_drinks TINYINT(1) NOT NULL, is_members_write TINYINT(1) NOT NULL, is_members_read TINYINT(1) NOT NULL, is_members_add TINYINT(1) NOT NULL, is_members_statistique_read TINYINT(1) NOT NULL, is_payment_schedules_write TINYINT(1) NOT NULL, is_payment_schedules_add TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E04992AA52AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83F73154ED4 FOREIGN KEY (leader_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83F73154ED4');
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AA52AFCFD6');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
