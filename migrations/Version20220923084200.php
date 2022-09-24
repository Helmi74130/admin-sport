<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923084200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission_leader (id INT AUTO_INCREMENT NOT NULL, leader_id INT DEFAULT NULL, is_sell_drinks TINYINT(1) NOT NULL, is_members_write TINYINT(1) NOT NULL, is_members_read TINYINT(1) NOT NULL, is_members_add TINYINT(1) NOT NULL, is_members_statistique_read TINYINT(1) NOT NULL, is_payment_schedules_write TINYINT(1) NOT NULL, is_payment_schedules_add TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3C394D3C73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission_leader ADD CONSTRAINT FK_3C394D3C73154ED4 FOREIGN KEY (leader_id) REFERENCES permission (id)');
        $this->addSql('ALTER TABLE hall CHANGE image_name image_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_leader DROP FOREIGN KEY FK_3C394D3C73154ED4');
        $this->addSql('DROP TABLE permission_leader');
        $this->addSql('ALTER TABLE hall CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
    }
}
