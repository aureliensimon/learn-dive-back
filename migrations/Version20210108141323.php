<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108141323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profondeur (id INT AUTO_INCREMENT NOT NULL, table_plongee_id_id INT NOT NULL, profondeur INT NOT NULL, INDEX IDX_E3804DEADC3CFF27 (table_plongee_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_plongee (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temps (id INT AUTO_INCREMENT NOT NULL, profondeur_id_id INT NOT NULL, temps INT NOT NULL, palier3 INT DEFAULT NULL, palier6 INT DEFAULT NULL, palier9 INT DEFAULT NULL, palier12 INT NOT NULL, palier15 INT DEFAULT NULL, INDEX IDX_60B4B720A43D0E15 (profondeur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profondeur ADD CONSTRAINT FK_E3804DEADC3CFF27 FOREIGN KEY (table_plongee_id_id) REFERENCES table_plongee (id)');
        $this->addSql('ALTER TABLE temps ADD CONSTRAINT FK_60B4B720A43D0E15 FOREIGN KEY (profondeur_id_id) REFERENCES profondeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temps DROP FOREIGN KEY FK_60B4B720A43D0E15');
        $this->addSql('ALTER TABLE profondeur DROP FOREIGN KEY FK_E3804DEADC3CFF27');
        $this->addSql('DROP TABLE profondeur');
        $this->addSql('DROP TABLE table_plongee');
        $this->addSql('DROP TABLE temps');
    }
}
