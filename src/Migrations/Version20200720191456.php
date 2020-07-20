<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720191456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `project_user_date` (date_id INT DEFAULT NULL, project_user_id INT DEFAULT NULL, `status` INT DEFAULT NULL, `mark` INT DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, INDEX IDX_C1233E64B897366B (date_id), INDEX IDX_C1233E643170DFF0 (project_user_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `direction_user` (direction_id INT DEFAULT NULL, user_id INT DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, INDEX IDX_25F11901AF73D997 (direction_id), INDEX IDX_25F11901A76ED395 (user_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (`status` INT DEFAULT NULL, `name` VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, `image_path` VARCHAR(255) DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, `deleted` DATETIME DEFAULT NULL, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_project_user (group_id INT NOT NULL, project_user_id INT NOT NULL, INDEX IDX_58445468FE54D947 (group_id), INDEX IDX_584454683170DFF0 (project_user_id), PRIMARY KEY(group_id, project_user_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_date (group_id INT NOT NULL, date_id INT NOT NULL, INDEX IDX_83C46C0AFE54D947 (group_id), INDEX IDX_83C46C0AB897366B (date_id), PRIMARY KEY(group_id, date_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_subject (group_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_7DCE6A76FE54D947 (group_id), INDEX IDX_7DCE6A7623EDC87 (subject_id), PRIMARY KEY(group_id, subject_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `date` (subject_id INT DEFAULT NULL, `status` INT DEFAULT NULL, `name` VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, `image_path` VARCHAR(255) DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, `deleted` DATETIME DEFAULT NULL, INDEX IDX_AA9E377A23EDC87 (subject_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `subject` (direction_id INT DEFAULT NULL, `status` INT DEFAULT NULL, `name` VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, `image_path` VARCHAR(255) DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, `deleted` DATETIME DEFAULT NULL, INDEX IDX_FBCE3E7AAF73D997 (direction_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `project` (`status` INT DEFAULT NULL, `name` VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, `email` VARCHAR(255) DEFAULT NULL, `image_path` VARCHAR(255) DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, `deleted` DATETIME DEFAULT NULL, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `project_user` (project_id INT DEFAULT NULL, user_id INT DEFAULT NULL, `status` INT DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user_direction (project_user_id INT NOT NULL, direction_id INT NOT NULL, INDEX IDX_D71D68F53170DFF0 (project_user_id), INDEX IDX_D71D68F5AF73D997 (direction_id), PRIMARY KEY(project_user_id, direction_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `direction` (project_id INT DEFAULT NULL, `status` INT DEFAULT NULL, `name` VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, `image_path` VARCHAR(255) DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `created` DATETIME NOT NULL, `updated` DATETIME NOT NULL, `deleted` DATETIME DEFAULT NULL, INDEX IDX_3E4AD1B3166D1F9C (project_id), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `project_user_date` ADD CONSTRAINT FK_C1233E64B897366B FOREIGN KEY (date_id) REFERENCES `date` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `project_user_date` ADD CONSTRAINT FK_C1233E643170DFF0 FOREIGN KEY (project_user_id) REFERENCES `project_user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `direction_user` ADD CONSTRAINT FK_25F11901AF73D997 FOREIGN KEY (direction_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `direction_user` ADD CONSTRAINT FK_25F11901A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_project_user ADD CONSTRAINT FK_58445468FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_project_user ADD CONSTRAINT FK_584454683170DFF0 FOREIGN KEY (project_user_id) REFERENCES `project_user` (id)');
        $this->addSql('ALTER TABLE group_date ADD CONSTRAINT FK_83C46C0AFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_date ADD CONSTRAINT FK_83C46C0AB897366B FOREIGN KEY (date_id) REFERENCES `date` (id)');
        $this->addSql('ALTER TABLE group_subject ADD CONSTRAINT FK_7DCE6A76FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE group_subject ADD CONSTRAINT FK_7DCE6A7623EDC87 FOREIGN KEY (subject_id) REFERENCES `subject` (id)');
        $this->addSql('ALTER TABLE `date` ADD CONSTRAINT FK_AA9E377A23EDC87 FOREIGN KEY (subject_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `subject` ADD CONSTRAINT FK_FBCE3E7AAF73D997 FOREIGN KEY (direction_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `project_user` ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `project_user` ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user_direction ADD CONSTRAINT FK_D71D68F53170DFF0 FOREIGN KEY (project_user_id) REFERENCES `project_user` (id)');
        $this->addSql('ALTER TABLE project_user_direction ADD CONSTRAINT FK_D71D68F5AF73D997 FOREIGN KEY (direction_id) REFERENCES `direction` (id)');
        $this->addSql('ALTER TABLE `direction` ADD CONSTRAINT FK_3E4AD1B3166D1F9C FOREIGN KEY (project_id) REFERENCES `project` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE test');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_project_user DROP FOREIGN KEY FK_58445468FE54D947');
        $this->addSql('ALTER TABLE group_date DROP FOREIGN KEY FK_83C46C0AFE54D947');
        $this->addSql('ALTER TABLE group_subject DROP FOREIGN KEY FK_7DCE6A76FE54D947');
        $this->addSql('ALTER TABLE `project_user_date` DROP FOREIGN KEY FK_C1233E64B897366B');
        $this->addSql('ALTER TABLE group_date DROP FOREIGN KEY FK_83C46C0AB897366B');
        $this->addSql('ALTER TABLE group_subject DROP FOREIGN KEY FK_7DCE6A7623EDC87');
        $this->addSql('ALTER TABLE `direction_user` DROP FOREIGN KEY FK_25F11901AF73D997');
        $this->addSql('ALTER TABLE `date` DROP FOREIGN KEY FK_AA9E377A23EDC87');
        $this->addSql('ALTER TABLE `subject` DROP FOREIGN KEY FK_FBCE3E7AAF73D997');
        $this->addSql('ALTER TABLE `project_user` DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE `direction` DROP FOREIGN KEY FK_3E4AD1B3166D1F9C');
        $this->addSql('ALTER TABLE `project_user_date` DROP FOREIGN KEY FK_C1233E643170DFF0');
        $this->addSql('ALTER TABLE group_project_user DROP FOREIGN KEY FK_584454683170DFF0');
        $this->addSql('ALTER TABLE project_user_direction DROP FOREIGN KEY FK_D71D68F53170DFF0');
        $this->addSql('ALTER TABLE project_user_direction DROP FOREIGN KEY FK_D71D68F5AF73D997');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, status INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE `project_user_date`');
        $this->addSql('DROP TABLE `direction_user`');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_project_user');
        $this->addSql('DROP TABLE group_date');
        $this->addSql('DROP TABLE group_subject');
        $this->addSql('DROP TABLE `date`');
        $this->addSql('DROP TABLE `subject`');
        $this->addSql('DROP TABLE `project`');
        $this->addSql('DROP TABLE `project_user`');
        $this->addSql('DROP TABLE project_user_direction');
        $this->addSql('DROP TABLE `direction`');
    }
}
