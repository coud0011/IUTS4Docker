<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212081937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $password = sha1("test");
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO user (email,roles,password,firstname,lastname) VALUES ('axel.coudrot@free.fr',['ROLE_ADMIN'], $password, 'Axel', 'Coudrot')");
    }

    public function down(Schema $schema): void
    {
    }
}
