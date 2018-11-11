<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181111131312 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contributor (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', created_by_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, short_name VARCHAR(70) NOT NULL, identifier VARCHAR(100) NOT NULL, location VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_DA6F9793772E836A (identifier), INDEX IDX_DA6F9793B03A8386 (created_by_id), INDEX type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributors_super_admins (contributor_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_3A116A427A19A357 (contributor_id), INDEX IDX_3A116A42A76ED395 (user_id), PRIMARY KEY(contributor_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributors_admins (contributor_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_30C5453F7A19A357 (contributor_id), INDEX IDX_30C5453FA76ED395 (user_id), PRIMARY KEY(contributor_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE open_date (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', created_by_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', start DATE NOT NULL, end DATE DEFAULT NULL, is_public TINYINT(1) NOT NULL, is_closed TINYINT(1) NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_136A765F7E3C61F9 (owner_id), INDEX IDX_136A765FB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE open_dates_invitations (open_date_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', contributor_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_956A00F0D5A3FA98 (open_date_id), INDEX IDX_956A00F07A19A357 (contributor_id), PRIMARY KEY(open_date_id, contributor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', improvisator_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649BE7F6774 (improvisator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, improvisator_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', improv_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', role VARCHAR(70) DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, is_hidden TINYINT(1) NOT NULL, INDEX IDX_86FFD285BE7F6774 (improvisator_id), INDEX IDX_86FFD285A4DBD25E (improv_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contributors_super_admins ADD CONSTRAINT FK_3A116A427A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributors_super_admins ADD CONSTRAINT FK_3A116A42A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributors_admins ADD CONSTRAINT FK_30C5453F7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributors_admins ADD CONSTRAINT FK_30C5453FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE open_date ADD CONSTRAINT FK_136A765F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE open_date ADD CONSTRAINT FK_136A765FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE open_dates_invitations ADD CONSTRAINT FK_956A00F0D5A3FA98 FOREIGN KEY (open_date_id) REFERENCES open_date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE open_dates_invitations ADD CONSTRAINT FK_956A00F07A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE7F6774 FOREIGN KEY (improvisator_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285BE7F6774 FOREIGN KEY (improvisator_id) REFERENCES contributor (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285A4DBD25E FOREIGN KEY (improv_group_id) REFERENCES contributor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributors_super_admins DROP FOREIGN KEY FK_3A116A427A19A357');
        $this->addSql('ALTER TABLE contributors_admins DROP FOREIGN KEY FK_30C5453F7A19A357');
        $this->addSql('ALTER TABLE open_date DROP FOREIGN KEY FK_136A765F7E3C61F9');
        $this->addSql('ALTER TABLE open_dates_invitations DROP FOREIGN KEY FK_956A00F07A19A357');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE7F6774');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD285BE7F6774');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD285A4DBD25E');
        $this->addSql('ALTER TABLE open_dates_invitations DROP FOREIGN KEY FK_956A00F0D5A3FA98');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793B03A8386');
        $this->addSql('ALTER TABLE contributors_super_admins DROP FOREIGN KEY FK_3A116A42A76ED395');
        $this->addSql('ALTER TABLE contributors_admins DROP FOREIGN KEY FK_30C5453FA76ED395');
        $this->addSql('ALTER TABLE open_date DROP FOREIGN KEY FK_136A765FB03A8386');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE contributors_super_admins');
        $this->addSql('DROP TABLE contributors_admins');
        $this->addSql('DROP TABLE open_date');
        $this->addSql('DROP TABLE open_dates_invitations');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE membership');
    }
}
