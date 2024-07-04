<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704120421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the category table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (
            id SERIAL PRIMARY KEY,
            parent_id INT,
            title VARCHAR(50) NOT NULL,
            description VARCHAR(30) NOT NULL,
            category VARCHAR(20) NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
    }
}
