<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006232650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permit_watch (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, entry_point_id INT NOT NULL, target_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, INDEX IDX_9DFE0606A76ED395 (user_id), INDEX IDX_9DFE0606AE6F2EEA (entry_point_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permit_watch ADD CONSTRAINT FK_9DFE0606A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE permit_watch ADD CONSTRAINT FK_9DFE0606AE6F2EEA FOREIGN KEY (entry_point_id) REFERENCES entry_point (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permit_watch DROP FOREIGN KEY FK_9DFE0606A76ED395');
        $this->addSql('ALTER TABLE permit_watch DROP FOREIGN KEY FK_9DFE0606AE6F2EEA');
        $this->addSql('DROP TABLE permit_watch');
    }
}
