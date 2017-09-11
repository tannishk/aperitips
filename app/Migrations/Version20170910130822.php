<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170910130822 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `users` CHANGE COLUMN `picture_path` `picture` VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE `users` ADD COLUMN `slug` VARCHAR(45) NOT NULL AFTER `email`');
        $this->addSql('ALTER TABLE `users` ADD COLUMN `creadted_at` DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `users` ADD COLUMN `updated_at` DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `users` CHANGE COLUMN `picture` `picture_path` VARCHAR(255) NULL');
        $this->addSql('ALTER TABLE `users` DROP COLUMN `slug`');
        $this->addSql('ALTER TABLE `users` DROP COLUMN `created_at`');
        $this->addSql('ALTER TABLE `users` DROP COLUMN `updated_at`');
    }
}
