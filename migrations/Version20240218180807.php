<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218180807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_article (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(10000) NOT NULL, image VARCHAR(500) NOT NULL, date_creation DATE NOT NULL, date_modify DATE DEFAULT NULL, statut VARCHAR(255) NOT NULL, users_id INT NOT NULL, INDEX IDX_EECCB3E567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE blog_comment (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(10000) NOT NULL, date_creation DATE NOT NULL, date_modify DATE DEFAULT NULL, blog_article_id INT DEFAULT NULL, users_id INT NOT NULL, INDEX IDX_7882EFEF9452A475 (blog_article_id), INDEX IDX_7882EFEF67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE civilisation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(10000) NOT NULL, emplacement VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE civilisation_programe (civilisation_id INT NOT NULL, programe_id INT NOT NULL, INDEX IDX_7E85BDD0C5E50B80 (civilisation_id), INDEX IDX_7E85BDD072E8E47F (programe_id), PRIMARY KEY(civilisation_id, programe_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, date_debuit DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, features LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE permission_module (permission_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_C5FE81C3FED90CCA (permission_id), INDEX IDX_C5FE81C3AFC2B591 (module_id), PRIMARY KEY(permission_id, module_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE programe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, duree INT NOT NULL, date DATE NOT NULL, reservation_id INT DEFAULT NULL, INDEX IDX_59DD014B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(10000) NOT NULL, reservation_id INT NOT NULL, UNIQUE INDEX UNIQ_CE606404B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE resrvation (id INT AUTO_INCREMENT NOT NULL, date_reservation DATE NOT NULL, users_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, INDEX IDX_CCF7E23B67B3B43D (users_id), INDEX IDX_CCF7E23B3243BB18 (hotel_id), INDEX IDX_CCF7E23BB1E7706E (restaurant_id), INDEX IDX_CCF7E23BFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, rate INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role_permission (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), INDEX IDX_6F7DF886FED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, cin VARCHAR(30) NOT NULL, num_tel VARCHAR(50) NOT NULL, mail VARCHAR(100) NOT NULL, password VARCHAR(32) NOT NULL, user_name VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, roles_id INT NOT NULL, INDEX IDX_8D93D64938C751C4 (roles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE blog_article ADD CONSTRAINT FK_EECCB3E567B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEF9452A475 FOREIGN KEY (blog_article_id) REFERENCES blog_comment (id)');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEF67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE civilisation_programe ADD CONSTRAINT FK_7E85BDD0C5E50B80 FOREIGN KEY (civilisation_id) REFERENCES civilisation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE civilisation_programe ADD CONSTRAINT FK_7E85BDD072E8E47F FOREIGN KEY (programe_id) REFERENCES programe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_module ADD CONSTRAINT FK_C5FE81C3FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_module ADD CONSTRAINT FK_C5FE81C3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programe ADD CONSTRAINT FK_59DD014B83297E7 FOREIGN KEY (reservation_id) REFERENCES resrvation (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404B83297E7 FOREIGN KEY (reservation_id) REFERENCES resrvation (id)');
        $this->addSql('ALTER TABLE resrvation ADD CONSTRAINT FK_CCF7E23B67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE resrvation ADD CONSTRAINT FK_CCF7E23B3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE resrvation ADD CONSTRAINT FK_CCF7E23BB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE resrvation ADD CONSTRAINT FK_CCF7E23BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64938C751C4 FOREIGN KEY (roles_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_article DROP FOREIGN KEY FK_EECCB3E567B3B43D');
        $this->addSql('ALTER TABLE blog_comment DROP FOREIGN KEY FK_7882EFEF9452A475');
        $this->addSql('ALTER TABLE blog_comment DROP FOREIGN KEY FK_7882EFEF67B3B43D');
        $this->addSql('ALTER TABLE civilisation_programe DROP FOREIGN KEY FK_7E85BDD0C5E50B80');
        $this->addSql('ALTER TABLE civilisation_programe DROP FOREIGN KEY FK_7E85BDD072E8E47F');
        $this->addSql('ALTER TABLE permission_module DROP FOREIGN KEY FK_C5FE81C3FED90CCA');
        $this->addSql('ALTER TABLE permission_module DROP FOREIGN KEY FK_C5FE81C3AFC2B591');
        $this->addSql('ALTER TABLE programe DROP FOREIGN KEY FK_59DD014B83297E7');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404B83297E7');
        $this->addSql('ALTER TABLE resrvation DROP FOREIGN KEY FK_CCF7E23B67B3B43D');
        $this->addSql('ALTER TABLE resrvation DROP FOREIGN KEY FK_CCF7E23B3243BB18');
        $this->addSql('ALTER TABLE resrvation DROP FOREIGN KEY FK_CCF7E23BB1E7706E');
        $this->addSql('ALTER TABLE resrvation DROP FOREIGN KEY FK_CCF7E23BFD02F13');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886FED90CCA');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64938C751C4');
        $this->addSql('DROP TABLE blog_article');
        $this->addSql('DROP TABLE blog_comment');
        $this->addSql('DROP TABLE civilisation');
        $this->addSql('DROP TABLE civilisation_programe');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE permission_module');
        $this->addSql('DROP TABLE programe');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE resrvation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
