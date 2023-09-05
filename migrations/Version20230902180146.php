<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902180146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP sous_categories_id');
        $this->addSql('ALTER TABLE sous_categories ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categories ADD CONSTRAINT FK_DC8B1382A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_DC8B1382A21214B7 ON sous_categories (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD sous_categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categories DROP FOREIGN KEY FK_DC8B1382A21214B7');
        $this->addSql('DROP INDEX IDX_DC8B1382A21214B7 ON sous_categories');
        $this->addSql('ALTER TABLE sous_categories DROP categories_id');
    }
}
