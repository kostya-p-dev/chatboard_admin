<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160922125812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, expired_at DATETIME NOT NULL, rest_token VARCHAR(255) NOT NULL, soc_token VARCHAR(255) DEFAULT NULL, soc_secret VARCHAR(255) DEFAULT NULL, INDEX IDX_1FF9EC48A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, fbid VARCHAR(40) DEFAULT NULL, twid VARCHAR(40) DEFAULT NULL, goid VARCHAR(40) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, role VARCHAR(100) NOT NULL, name VARCHAR(50) NOT NULL, age VARCHAR(50) DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, primary_interests_img VARCHAR(255) DEFAULT NULL, interests_str VARCHAR(255) DEFAULT NULL, about VARCHAR(320) DEFAULT NULL, created DATETIME NOT NULL, access INT DEFAULT NULL, login INT DEFAULT NULL, status TINYINT(1) DEFAULT NULL, gender TINYINT(1) DEFAULT NULL, lan_status TINYINT(1) DEFAULT NULL, isRegister TINYINT(1) DEFAULT NULL, timezone VARCHAR(6) DEFAULT NULL, isOnline TINYINT(1) DEFAULT \'0\' COMMENT \'Is User Online\', phone VARCHAR(20) DEFAULT NULL, INDEX fbid_idx (fbid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserFiles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fileorder INT NOT NULL, path VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, INDEX IDX_62A1D12CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Files (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(100) DEFAULT NULL, path VARCHAR(255) NOT NULL, fileorder INT NOT NULL, created_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, INDEX IDX_C7F46F5DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Session ADD CONSTRAINT FK_1FF9EC48A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE UserFiles ADD CONSTRAINT FK_62A1D12CA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Files ADD CONSTRAINT FK_C7F46F5DA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Session DROP FOREIGN KEY FK_1FF9EC48A76ED395');
        $this->addSql('ALTER TABLE UserFiles DROP FOREIGN KEY FK_62A1D12CA76ED395');
        $this->addSql('ALTER TABLE Files DROP FOREIGN KEY FK_C7F46F5DA76ED395');
        $this->addSql('DROP TABLE Session');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE UserFiles');
        $this->addSql('DROP TABLE Files');
    }
}
