<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327125624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fruit (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', family_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', genus_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', order_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', nutrition_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, fruit_id INT NOT NULL, is_favorite TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A00BD297A508F282 (family_uuid), INDEX IDX_A00BD2977ABA565E (genus_uuid), INDEX IDX_A00BD2979C8E6AB1 (order_uuid), UNIQUE INDEX UNIQ_A00BD297FA45BE35 (nutrition_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit_family (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit_genus (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit_nutrition (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', carbohydrates DOUBLE PRECISION NOT NULL, protein DOUBLE PRECISION NOT NULL, fat DOUBLE PRECISION NOT NULL, calories DOUBLE PRECISION NOT NULL, sugar DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit_order (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fruit ADD CONSTRAINT FK_A00BD297A508F282 FOREIGN KEY (family_uuid) REFERENCES fruit_family (uuid)');
        $this->addSql('ALTER TABLE fruit ADD CONSTRAINT FK_A00BD2977ABA565E FOREIGN KEY (genus_uuid) REFERENCES fruit_genus (uuid)');
        $this->addSql('ALTER TABLE fruit ADD CONSTRAINT FK_A00BD2979C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES fruit_order (uuid)');
        $this->addSql('ALTER TABLE fruit ADD CONSTRAINT FK_A00BD297FA45BE35 FOREIGN KEY (nutrition_uuid) REFERENCES fruit_nutrition (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fruit DROP FOREIGN KEY FK_A00BD297A508F282');
        $this->addSql('ALTER TABLE fruit DROP FOREIGN KEY FK_A00BD2977ABA565E');
        $this->addSql('ALTER TABLE fruit DROP FOREIGN KEY FK_A00BD2979C8E6AB1');
        $this->addSql('ALTER TABLE fruit DROP FOREIGN KEY FK_A00BD297FA45BE35');
        $this->addSql('DROP TABLE fruit');
        $this->addSql('DROP TABLE fruit_family');
        $this->addSql('DROP TABLE fruit_genus');
        $this->addSql('DROP TABLE fruit_nutrition');
        $this->addSql('DROP TABLE fruit_order');
    }
}
