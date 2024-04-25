<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425121813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F275ED078');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638275ED078');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_filiere (project_id INT NOT NULL, filiere_id INT NOT NULL, INDEX IDX_B8CE51FB166D1F9C (project_id), INDEX IDX_B8CE51FB180AA129 (filiere_id), PRIMARY KEY(project_id, filiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_competence (project_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_8C72134D166D1F9C (project_id), INDEX IDX_8C72134D15761DAB (competence_id), PRIMARY KEY(project_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_competence (user_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_33B3AE93A76ED395 (user_id), INDEX IDX_33B3AE9315761DAB (competence_id), PRIMARY KEY(user_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_filiere ADD CONSTRAINT FK_B8CE51FB166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_filiere ADD CONSTRAINT FK_B8CE51FB180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_competence ADD CONSTRAINT FK_8C72134D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_competence ADD CONSTRAINT FK_8C72134D15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_competence ADD CONSTRAINT FK_33B3AE93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_competence ADD CONSTRAINT FK_33B3AE9315761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297A76ED395');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP INDEX IDX_94D4687F275ED078 ON competence');
        $this->addSql('ALTER TABLE competence DROP profil_id');
        $this->addSql('DROP INDEX UNIQ_4C62E638275ED078 ON contact');
        $this->addSql('ALTER TABLE contact CHANGE profil_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638A76ED395 ON contact (user_id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA76ED395');
        $this->addSql('DROP INDEX IDX_6A2CA10CA76ED395 ON media');
        $this->addSql('ALTER TABLE media DROP user_id');
        $this->addSql('ALTER TABLE message DROP INDEX UNIQ_B6BD307F166D1F9C, ADD INDEX IDX_B6BD307F166D1F9C (project_id)');
        $this->addSql('ALTER TABLE message ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('ALTER TABLE project DROP filiere');
        $this->addSql('ALTER TABLE user ADD biographie VARCHAR(90) NOT NULL, ADD reve VARCHAR(50) NOT NULL, CHANGE type filiere_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649180AA129 ON user (filiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649180AA129');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, biography LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, filiere INT NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_filiere DROP FOREIGN KEY FK_B8CE51FB166D1F9C');
        $this->addSql('ALTER TABLE project_filiere DROP FOREIGN KEY FK_B8CE51FB180AA129');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('ALTER TABLE project_competence DROP FOREIGN KEY FK_8C72134D166D1F9C');
        $this->addSql('ALTER TABLE project_competence DROP FOREIGN KEY FK_8C72134D15761DAB');
        $this->addSql('ALTER TABLE user_competence DROP FOREIGN KEY FK_33B3AE93A76ED395');
        $this->addSql('ALTER TABLE user_competence DROP FOREIGN KEY FK_33B3AE9315761DAB');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE project_filiere');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE project_competence');
        $this->addSql('DROP TABLE user_competence');
        $this->addSql('ALTER TABLE competence ADD profil_id INT NOT NULL');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_94D4687F275ED078 ON competence (profil_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A76ED395');
        $this->addSql('DROP INDEX IDX_4C62E638A76ED395 ON contact');
        $this->addSql('ALTER TABLE contact CHANGE user_id profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638275ED078 ON contact (profil_id)');
        $this->addSql('ALTER TABLE media ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CA76ED395 ON media (user_id)');
        $this->addSql('ALTER TABLE message DROP INDEX IDX_B6BD307F166D1F9C, ADD UNIQUE INDEX UNIQ_B6BD307F166D1F9C (project_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message DROP user_id');
        $this->addSql('ALTER TABLE project ADD filiere INT NOT NULL');
        $this->addSql('DROP INDEX IDX_8D93D649180AA129 ON user');
        $this->addSql('ALTER TABLE user DROP biographie, DROP reve, CHANGE filiere_id type INT DEFAULT NULL');
    }
}
