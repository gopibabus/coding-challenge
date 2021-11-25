<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20211125145225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added created and updated fields to note table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note DROP created_at, DROP updated_at');
    }
}
