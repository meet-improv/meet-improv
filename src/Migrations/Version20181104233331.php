<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104233331 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contributor (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, short_name VARCHAR(20) NOT NULL, identifier VARCHAR(100) NOT NULL, location VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_DA6F9793772E836A (identifier), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', improvisator_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649BE7F6774 (improvisator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, improvisator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', improv_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', role VARCHAR(50) DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, is_hidden TINYINT(1) NOT NULL, INDEX IDX_86FFD285BE7F6774 (improvisator_id), INDEX IDX_86FFD285A4DBD25E (improv_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE7F6774 FOREIGN KEY (improvisator_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285BE7F6774 FOREIGN KEY (improvisator_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285A4DBD25E FOREIGN KEY (improv_group_id) REFERENCES contributor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE7F6774');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD285BE7F6774');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD285A4DBD25E');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE membership');
    }
}
