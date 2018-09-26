<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180925095714 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, agency_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, web_address VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, established VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP INDEX IDX_E19D9AD2CDEADB2A ON service');
        $this->addSql('ALTER TABLE service DROP agency_id');
        $this->addSql('ALTER TABLE agency_service ADD CONSTRAINT FK_979D0383CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agency_service ADD CONSTRAINT FK_979D0383ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agency_service DROP FOREIGN KEY FK_979D0383CDEADB2A');
        $this->addSql('DROP TABLE agency');
        $this->addSql('ALTER TABLE agency_service DROP FOREIGN KEY FK_979D0383ED5CA9E6');
        $this->addSql('ALTER TABLE service ADD agency_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_E19D9AD2CDEADB2A ON service (agency_id)');
    }
}
