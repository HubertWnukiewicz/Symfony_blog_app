<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210828192421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_comment (id INT AUTO_INCREMENT NOT NULL, blog_id_id INT NOT NULL, text VARCHAR(255) NOT NULL, is_visible TINYINT(1) NOT NULL, insert_date DATETIME NOT NULL, INDEX IDX_7882EFEF8FABDD9F (blog_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEF8FABDD9F FOREIGN KEY (blog_id_id) REFERENCES blog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_comment');
    }
}
