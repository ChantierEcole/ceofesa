<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170620153935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tb_Devis ADD idDAF_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tb_Devis ADD CONSTRAINT FK_200DBADF35A2E4F FOREIGN KEY (idDAF_id) REFERENCES tb_DAF (daf_ID)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_200DBADF35A2E4F ON tb_Devis (idDAF_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tb_Devis DROP FOREIGN KEY FK_200DBADF35A2E4F');
        $this->addSql('DROP INDEX UNIQ_200DBADF35A2E4F ON tb_Devis');
        $this->addSql('ALTER TABLE tb_Devis DROP idDAF_id');
    }
}
