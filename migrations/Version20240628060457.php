<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628060457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE muscle_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise ADD muscle_group_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C44004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_group (id)');
        $this->addSql('CREATE INDEX IDX_AEDAD51C44004D0 ON exercise (muscle_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C44004D0');
        $this->addSql('DROP TABLE muscle_group');
        $this->addSql('DROP INDEX IDX_AEDAD51C44004D0 ON exercise');
        $this->addSql('ALTER TABLE exercise ADD type VARCHAR(100) NOT NULL, DROP muscle_group_id');
    }
}
