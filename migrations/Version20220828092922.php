<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828092922 extends AbstractMigration
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
        $this->addSql('CREATE INDEX IDX_1B8FA83FA76ED395 ON hall (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FA76ED395');
        $this->addSql('DROP INDEX IDX_1B8FA83FA76ED395 ON hall');
        $this->addSql('ALTER TABLE hall DROP user_id');
    }
}
