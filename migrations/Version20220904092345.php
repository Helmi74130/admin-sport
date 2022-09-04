<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904092345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B8FA83FA76ED395 ON hall (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64952AFCFD6');
        $this->addSql('DROP INDEX UNIQ_8D93D64952AFCFD6 ON user');
        $this->addSql('ALTER TABLE user DROP hall_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FA76ED395');
        $this->addSql('DROP INDEX UNIQ_1B8FA83FA76ED395 ON hall');
        $this->addSql('ALTER TABLE hall DROP user_id');
        $this->addSql('ALTER TABLE user ADD hall_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64952AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64952AFCFD6 ON user (hall_id)');
    }
}
