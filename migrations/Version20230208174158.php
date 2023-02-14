<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208174158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `characters` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `origin_name` VARCHAR(255) NOT NULL,
                    `origin_url` VARCHAR(255) NOT NULL,
                    `url` VARCHAR(255) NOT NULL,
                    `image` VARCHAR(255) NOT NULL,
                    `status` VARCHAR(255) NOT NULL,
                    `species` VARCHAR(255) NOT NULL,
                    `type` VARCHAR(255) NOT NULL,
                    `gender` VARCHAR(255) NOT NULL,
                    `created` DATETIME NOT NULL,
                    PRIMARY KEY(id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `characters`');
    }
}
