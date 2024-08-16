<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240815134252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rating_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin_comment (id INT NOT NULL, member_id INT NOT NULL, product_id INT NOT NULL, comment VARCHAR(150) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5048D0E57597D3FE ON admin_comment (member_id)');
        $this->addSql('CREATE INDEX IDX_5048D0E54584665A ON admin_comment (product_id)');
        $this->addSql('COMMENT ON COLUMN admin_comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(30) NOT NULL, category VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78E7927C74 ON member (email)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, member_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(145) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD7597D3FE ON product (member_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE TABLE rating (id INT NOT NULL, product_id INT NOT NULL, member_id INT NOT NULL, rating INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D88926224584665A ON rating (product_id)');
        $this->addSql('CREATE INDEX IDX_D88926227597D3FE ON rating (member_id)');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT FK_5048D0E57597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT FK_5048D0E54584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926224584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926227597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE admin_comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rating_id_seq CASCADE');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT FK_5048D0E57597D3FE');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT FK_5048D0E54584665A');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD7597D3FE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D88926224584665A');
        $this->addSql('ALTER TABLE rating DROP CONSTRAINT FK_D88926227597D3FE');
        $this->addSql('DROP TABLE admin_comment');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE rating');
    }
}
