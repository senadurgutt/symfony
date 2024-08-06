<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240806062501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key constraints to admin_comment table with userid and product_id columns';
    }

    public function up(Schema $schema): void
    {
        // Kolonları sadece mevcut değilse ekleyin
        $this->addSql('ALTER TABLE admin_comment ADD COLUMN IF NOT EXISTS userid INT NOT NULL');
        $this->addSql('ALTER TABLE admin_comment ADD COLUMN IF NOT EXISTS product_id INT NOT NULL');

        // Önceki constraint'leri sadece mevcutsa kaldırın
        $this->addSql('DO $$ BEGIN IF EXISTS (SELECT 1 FROM pg_constraint WHERE conname = \'fk_5048d0e5a76ed395\') THEN ALTER TABLE admin_comment DROP CONSTRAINT fk_5048d0e5a76ed395; END IF; END $$;');
        $this->addSql('DO $$ BEGIN IF EXISTS (SELECT 1 FROM pg_constraint WHERE conname = \'fk_5048d0e54584665a\') THEN ALTER TABLE admin_comment DROP CONSTRAINT fk_5048d0e54584665a; END IF; END $$;');

        // Önceki index'leri kaldır
        $this->addSql('DROP INDEX IF EXISTS idx_5048d0e5a76ed395');
        $this->addSql('DROP INDEX IF EXISTS idx_5048d0e54584665a');

        // Kolonlar için constraint ekle
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT FK_5048D0E5A76ED395 FOREIGN KEY (userid) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_comment ADD CONSTRAINT FK_5048D0E54584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Kolonlar için index ekle
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_5048D0E5A76ED395 ON admin_comment (userid)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_5048D0E54584665A ON admin_comment (product_id)');
    }

    public function down(Schema $schema): void
    {
        // Kolonlar için constraint'leri kaldır
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT IF EXISTS FK_5048D0E5A76ED395');
        $this->addSql('ALTER TABLE admin_comment DROP CONSTRAINT IF EXISTS FK_5048D0E54584665A');

        // Kolonlar için index'leri kaldır
        $this->addSql('DROP INDEX IF EXISTS IDX_5048D0E5A76ED395');
        $this->addSql('DROP INDEX IF EXISTS IDX_5048D0E54584665A');

        // Kolonları kaldır
        $this->addSql('ALTER TABLE admin_comment DROP COLUMN IF EXISTS userid');
        $this->addSql('ALTER TABLE admin_comment DROP COLUMN IF EXISTS product_id');
    }
}
