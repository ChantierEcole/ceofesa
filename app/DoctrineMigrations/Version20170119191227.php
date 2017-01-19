<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170119191227 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE tb_Devis t SET t.dev_Structure=172 WHERE t.dev_ID IN (1908, 1909, 1910)');
        $this->addSql('UPDATE tb_Tiers t INNER JOIN tb_DParcours dp ON t.trs_ID = dp.dpr_Tiers SET t.trs_Structure=172 WHERE dp.dpr_Devis IN (1908, 1909, 1910) AND t.trs_Structure=27');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE tb_Devis t SET t.dev_Structure=27 WHERE t.dev_ID IN (1908, 1909, 1910)');
        $this->addSql('UPDATE tb_Tiers t INNER JOIN tb_DParcours dp ON t.trs_ID = dp.dpr_Tiers SET t.trs_Structure=27 WHERE dp.dpr_Devis IN (1908, 1909, 1910) AND t.trs_Structure=172');
    }
}
