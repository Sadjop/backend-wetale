<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314080828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter ADD chapter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('CREATE INDEX IDX_F981B52E579F4768 ON chapter (chapter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E579F4768');
        $this->addSql('DROP INDEX IDX_F981B52E579F4768 ON chapter');
        $this->addSql('ALTER TABLE chapter DROP chapter_id');
    }
}
