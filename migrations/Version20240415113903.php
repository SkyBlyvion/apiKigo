<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415113903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, project_id INT NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_94D4687F275ED078 (profil_id), INDEX IDX_94D4687F166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, profil_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4C62E638C54C8C93 (type_id), UNIQUE INDEX UNIQ_4C62E638275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, url_img VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6A2CA10C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, text LONGTEXT NOT NULL, date_created DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_B6BD307F166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, type INT NOT NULL, created_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, biography LONGTEXT NOT NULL, filiere INT NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, filiere INT NOT NULL, is_finish TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2FB3D0EE4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, type INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F275ED078');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F166D1F9C');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638C54C8C93');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638275ED078');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4B89032C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F166D1F9C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297A76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE4B89032C');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
