<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104114340 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, improvisator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', improv_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', role VARCHAR(50) DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, is_hidden TINYINT(1) NOT NULL, INDEX IDX_86FFD285BE7F6774 (improvisator_id), INDEX IDX_86FFD285A4DBD25E (improv_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285BE7F6774 FOREIGN KEY (improvisator_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285A4DBD25E FOREIGN KEY (improv_group_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE contributor ADD identifier VARCHAR(100) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD location VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6F9793772E836A ON contributor (identifier)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membership');
        $this->addSql('DROP INDEX UNIQ_DA6F9793772E836A ON contributor');
        $this->addSql('ALTER TABLE contributor DROP identifier, DROP created_at, DROP updated_at, DROP location');
    }
}
