<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240806073334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Sequence mevcutsa sadece kaldır
        $this->addSql('DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = \'admin_command_id_seq\') THEN
                    EXECUTE \'DROP SEQUENCE admin_command_id_seq CASCADE\';
                END IF;
            END
        $$;');

        // Kolonun not null kısıtlamasını kaldır
        $this->addSql('ALTER TABLE admin_comment ALTER userid DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Sequence oluştur
        $this->addSql('CREATE SCHEMA IF NOT EXISTS public');
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS admin_command_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        // Kolonun not null kısıtlamasını geri getir
        $this->addSql('ALTER TABLE admin_comment ALTER userid SET NOT NULL');
    }
}
