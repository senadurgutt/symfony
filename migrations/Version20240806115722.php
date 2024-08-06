<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240806115722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Temporarily allow NULL values
        $this->addSql('ALTER TABLE admin_comment ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT fk_5048d0e5f132696e');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT fk_5048d0e5a76ed395');
        $this->addSql('DROP INDEX idx_5048d0e5a76ed395');
        $this->addSql('DROP INDEX idx_5048d0e5f132696e');
        $this->addSql('ALTER TABLE admin_comment DROP userid');
        $this->addSql('UPDATE admin_comment SET member_id = 9 WHERE member_id IS NULL'); // Or any valid Member ID
        $this->addSql('ALTER TABLE admin_comment ALTER COLUMN member_id SET NOT NULL');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT FK_5048D0E57597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5048D0E57597D3FE ON admin_comment (member_id)');
    }



    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE admin_command_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT FK_5048D0E57597D3FE');
        $this->addSql('DROP INDEX IDX_5048D0E57597D3FE');
        $this->addSql('ALTER TABLE admin_comment ADD userid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_comment DROP member_id');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT fk_5048d0e5f132696e FOREIGN KEY (userid) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT fk_5048d0e5a76ed395 FOREIGN KEY (userid) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5048d0e5a76ed395 ON admin_comment (userid)');
        $this->addSql('CREATE INDEX idx_5048d0e5f132696e ON admin_comment (userid)');
    }
}
