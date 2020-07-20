<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720192407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE direction_user DROP FOREIGN KEY FK_25F11901AF73D997');
        $this->addSql('ALTER TABLE direction_user ADD CONSTRAINT FK_25F11901AF73D997 FOREIGN KEY (direction_id) REFERENCES `direction` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE date DROP FOREIGN KEY FK_AA9E377A23EDC87');
        $this->addSql('ALTER TABLE date ADD CONSTRAINT FK_AA9E377A23EDC87 FOREIGN KEY (subject_id) REFERENCES `subject` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7AAF73D997');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AAF73D997 FOREIGN KEY (direction_id) REFERENCES `direction` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `date` DROP FOREIGN KEY FK_AA9E377A23EDC87');
        $this->addSql('ALTER TABLE `date` ADD CONSTRAINT FK_AA9E377A23EDC87 FOREIGN KEY (subject_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `direction_user` DROP FOREIGN KEY FK_25F11901AF73D997');
        $this->addSql('ALTER TABLE `direction_user` ADD CONSTRAINT FK_25F11901AF73D997 FOREIGN KEY (direction_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `subject` DROP FOREIGN KEY FK_FBCE3E7AAF73D997');
        $this->addSql('ALTER TABLE `subject` ADD CONSTRAINT FK_FBCE3E7AAF73D997 FOREIGN KEY (direction_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
