<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923084559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_leader DROP FOREIGN KEY FK_3C394D3C73154ED4');
        $this->addSql('ALTER TABLE permission_leader ADD CONSTRAINT FK_3C394D3C73154ED4 FOREIGN KEY (leader_id) REFERENCES leader (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_leader DROP FOREIGN KEY FK_3C394D3C73154ED4');
        $this->addSql('ALTER TABLE permission_leader ADD CONSTRAINT FK_3C394D3C73154ED4 FOREIGN KEY (leader_id) REFERENCES permission (id)');
    }
}
