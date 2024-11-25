<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125101841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE power DROP FOREIGN KEY FK_AB8A01A0AB4FC384');
        $this->addSql('DROP INDEX UNIQ_AB8A01A0AB4FC384 ON power');
        $this->addSql('ALTER TABLE power ADD power_hero_id INT DEFAULT NULL, DROP power_id');
        $this->addSql('ALTER TABLE power ADD CONSTRAINT FK_AB8A01A0C4F59FB1 FOREIGN KEY (power_hero_id) REFERENCES super_heros (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB8A01A0C4F59FB1 ON power (power_hero_id)');
        $this->addSql('ALTER TABLE super_heros DROP power_hero_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE super_heros ADD power_hero_id INT NOT NULL');
        $this->addSql('ALTER TABLE power DROP FOREIGN KEY FK_AB8A01A0C4F59FB1');
        $this->addSql('DROP INDEX UNIQ_AB8A01A0C4F59FB1 ON power');
        $this->addSql('ALTER TABLE power ADD power_id INT NOT NULL, DROP power_hero_id');
        $this->addSql('ALTER TABLE power ADD CONSTRAINT FK_AB8A01A0AB4FC384 FOREIGN KEY (power_id) REFERENCES power (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB8A01A0AB4FC384 ON power (power_id)');
    }
}
