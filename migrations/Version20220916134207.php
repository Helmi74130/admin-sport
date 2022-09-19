<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916134207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, email VARCHAR(180) NOT NULL, subject VARCHAR(100) DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, name VARCHAR(150) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, street_number INT NOT NULL, adress LONGTEXT NOT NULL, city VARCHAR(150) NOT NULL, isactive TINYINT(1) NOT NULL, phone VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, INDEX IDX_1B8FA83F73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, city VARCHAR(80) NOT NULL, phone VARCHAR(15) NOT NULL, civility VARCHAR(5) NOT NULL, email VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leader_hall (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, city VARCHAR(80) NOT NULL, phone VARCHAR(15) NOT NULL, is_active TINYINT(1) NOT NULL, civility VARCHAR(5) NOT NULL, email VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_6D2A13052AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, is_sell_drinks TINYINT(1) NOT NULL, is_members_write TINYINT(1) NOT NULL, is_members_read TINYINT(1) NOT NULL, is_members_add TINYINT(1) NOT NULL, is_members_statistique_read TINYINT(1) NOT NULL, is_payment_schedules_write TINYINT(1) NOT NULL, is_payment_schedules_add TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E04992AA52AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, leader_id INT DEFAULT NULL, leader_hall_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, is_verified TINYINT(1) NOT NULL, civility VARCHAR(5) NOT NULL, phone VARCHAR(15) NOT NULL, city VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64973154ED4 (leader_id), UNIQUE INDEX UNIQ_8D93D6499DEB1EF6 (leader_hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83F73154ED4 FOREIGN KEY (leader_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE leader_hall ADD CONSTRAINT FK_6D2A13052AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64973154ED4 FOREIGN KEY (leader_id) REFERENCES leader (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499DEB1EF6 FOREIGN KEY (leader_hall_id) REFERENCES leader_hall (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83F73154ED4');
        $this->addSql('ALTER TABLE leader_hall DROP FOREIGN KEY FK_6D2A13052AFCFD6');
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AA52AFCFD6');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64973154ED4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499DEB1EF6');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE leader_hall');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
