<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151222174635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tb_BonCde ADD bcd_DAF INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tb_BonCde ADD CONSTRAINT FK_C08B7BC9F1B78EC2 FOREIGN KEY (bcd_DAF) REFERENCES tb_DAF (daf_ID)');
        $this->addSql('CREATE INDEX IDX_C08B7BC9F1B78EC2 ON tb_BonCde (bcd_DAF)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tb_BonCde DROP FOREIGN KEY FK_C08B7BC9F1B78EC2');
        $this->addSql('DROP INDEX IDX_C08B7BC9F1B78EC2 ON tb_BonCde');
        $this->addSql('ALTER TABLE tb_BonCde DROP bcd_DAF');
    }
}
