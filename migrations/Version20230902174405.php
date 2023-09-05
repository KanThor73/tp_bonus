<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902174405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('DROP INDEX IDX_3AF34668727ACA70 ON categories');
        $this->addSql('ALTER TABLE categories ADD sous_categories_id INT NOT NULL, DROP parent_id');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346689F751138 FOREIGN KEY (sous_categories_id) REFERENCES sous_categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF346689F751138 ON categories (sous_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346689F751138');
        $this->addSql('DROP INDEX IDX_3AF346689F751138 ON categories');
        $this->addSql('ALTER TABLE categories ADD parent_id INT DEFAULT NULL, DROP sous_categories_id');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES sous_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3AF34668727ACA70 ON categories (parent_id)');
    }
}
