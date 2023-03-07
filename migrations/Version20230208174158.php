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
                    `id` int NOT NULL,
                    `name` VARCHAR(255) NOT NULL,
                    `origin_name` VARCHAR(255) NOT NULL,
                    `origin_url` VARCHAR(255) NOT NULL,
                    `url` VARCHAR(255) NOT NULL,
                    `image` VARCHAR(255) NOT NULL,
                    `status` ENUM(\'Alive\', \'unknown\', \'Dead\') NOT NULL,
                    `species` ENUM(\'Human\', \'Alien\', \'Humanoid\', \'unknown\', ' . 
                    '\'Poopybutthole\', \'Mythological Creature\', \'Animal\', \'Robot\', \'Cronenberg\', \'Disease\') NOT NULL,
                    `type` VARCHAR(255) NOT NULL,
                    `gender` ENUM(\'Male\', \'Female\', \'Genderless\', \'unknown\') NOT NULL,
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
