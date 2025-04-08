<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314081846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE library_story (library_id INT NOT NULL, story_id INT NOT NULL, INDEX IDX_D8F3D617FE2541D7 (library_id), INDEX IDX_D8F3D617AA5D4036 (story_id), PRIMARY KEY(library_id, story_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE library_story ADD CONSTRAINT FK_D8F3D617FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library_story ADD CONSTRAINT FK_D8F3D617AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E579F4768');
        $this->addSql('DROP INDEX IDX_F981B52E579F4768 ON chapter');
        $this->addSql('ALTER TABLE chapter DROP chapter_id');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9579F4768');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9AA5D4036');
        $this->addSql('DROP INDEX IDX_68C58ED9579F4768 ON favorite');
        $this->addSql('ALTER TABLE favorite DROP chapter_id, CHANGE user_id user_id INT NOT NULL, CHANGE story_id story_id INT NOT NULL');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library DROP INDEX IDX_A18098BCA76ED395, ADD UNIQUE INDEX UNIQ_A18098BCA76ED395 (user_id)');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BCAA5D4036');
        $this->addSql('DROP INDEX IDX_A18098BCAA5D4036 ON library');
        $this->addSql('ALTER TABLE library DROP story_id');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564579F4768');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote CHANGE chapter_id chapter_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE library_story DROP FOREIGN KEY FK_D8F3D617FE2541D7');
        $this->addSql('ALTER TABLE library_story DROP FOREIGN KEY FK_D8F3D617AA5D4036');
        $this->addSql('DROP TABLE library_story');
        $this->addSql('ALTER TABLE chapter ADD chapter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F981B52E579F4768 ON chapter (chapter_id)');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564579F4768');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote CHANGE chapter_id chapter_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9AA5D4036');
        $this->addSql('ALTER TABLE favorite ADD chapter_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE story_id story_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_68C58ED9579F4768 ON favorite (chapter_id)');
        $this->addSql('ALTER TABLE library DROP INDEX UNIQ_A18098BCA76ED395, ADD INDEX IDX_A18098BCA76ED395 (user_id)');
        $this->addSql('ALTER TABLE library ADD story_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BCAA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A18098BCAA5D4036 ON library (story_id)');
    }
}
