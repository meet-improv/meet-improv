<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113184012 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor ADD troupe_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\'');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793EF084B38 FOREIGN KEY (troupe_id) REFERENCES contributor (id)');
        $this->addSql('CREATE INDEX IDX_DA6F9793EF084B38 ON contributor (troupe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793EF084B38');
        $this->addSql('DROP INDEX IDX_DA6F9793EF084B38 ON contributor');
        $this->addSql('ALTER TABLE contributor DROP troupe_id');
    }
}
