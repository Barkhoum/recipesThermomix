<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421223331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, name INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape_recipe (etape_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_6D8577884A8CA2AD (etape_id), INDEX IDX_6D85778859D8A214 (recipe_id), PRIMARY KEY(etape_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instruction (id INT AUTO_INCREMENT NOT NULL, instruction_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7BBAE15662A10F76 (instruction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etape_recipe ADD CONSTRAINT FK_6D8577884A8CA2AD FOREIGN KEY (etape_id) REFERENCES etape (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etape_recipe ADD CONSTRAINT FK_6D85778859D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instruction ADD CONSTRAINT FK_7BBAE15662A10F76 FOREIGN KEY (instruction_id) REFERENCES etape (id)');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etape_recipe DROP FOREIGN KEY FK_6D8577884A8CA2AD');
        $this->addSql('ALTER TABLE instruction DROP FOREIGN KEY FK_7BBAE15662A10F76');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE etape_recipe');
        $this->addSql('DROP TABLE instruction');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }
}
