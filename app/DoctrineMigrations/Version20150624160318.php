<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150624160318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(' ALTER TABLE tb_Parcours DROP FOREIGN KEY FK_5860A9AB8B0E8D1E');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EA3ABF8E06');
        $this->addSql(' ALTER TABLE tb_DParcours DROP FOREIGN KEY FK_9AA5BF0F2CEA72D8');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EA4D6FBF17');
        $this->addSql(' ALTER TABLE tb_DCont DROP FOREIGN KEY FK_6786D1A6CA98095F');
        $this->addSql(' ALTER TABLE tb_Tiers DROP FOREIGN KEY FK_BD6D4456FA5A8103');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EAE56FA7E5');

        $this->addSql('ALTER TABLE tb_ModuleT CHANGE mty_ID mty_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tb_FormationT CHANGE fty_ID fty_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tb_SortieT CHANGE srt_ID srt_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tb_CiviliteT CHANGE cty_ID cty_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tb_Session CHANGE ses_SType ses_SType INT NOT NULL, CHANGE ses_FType ses_FType INT NOT NULL');
        $this->addSql('ALTER TABLE tb_SessionT CHANGE sty_ID sty_ID INT NOT NULL');

        $this->addSql(' ALTER TABLE tb_Parcours ADD CONSTRAINT FK_5860A9AB8B0E8D1E FOREIGN KEY (prc_Type) REFERENCES tb_ModuleT(mty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EA3ABF8E06 FOREIGN KEY (ses_MType) REFERENCES tb_ModuleT(mty_ID)');
        $this->addSql(' ALTER TABLE tb_DParcours ADD CONSTRAINT FK_9AA5BF0F2CEA72D8 FOREIGN KEY (dpr_Type) REFERENCES tb_ModuleT(mty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EA4D6FBF17 FOREIGN KEY (ses_FType) REFERENCES tb_FormationT(fty_ID)');
        $this->addSql(' ALTER TABLE tb_DCont ADD CONSTRAINT FK_6786D1A6CA98095F FOREIGN KEY (cnt_MotifSortie) REFERENCES tb_SortieT(srt_ID)');
        $this->addSql(' ALTER TABLE tb_Tiers ADD CONSTRAINT FK_BD6D4456FA5A8103 FOREIGN KEY (trs_Civilite) REFERENCES tb_CiviliteT(cty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EAE56FA7E5 FOREIGN KEY (ses_SType) REFERENCES tb_SessionT(sty_ID)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(' ALTER TABLE tb_Parcours DROP FOREIGN KEY FK_5860A9AB8B0E8D1E');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EA3ABF8E06');
        $this->addSql(' ALTER TABLE tb_DParcours DROP FOREIGN KEY FK_9AA5BF0F2CEA72D8');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EA4D6FBF17');
        $this->addSql(' ALTER TABLE tb_DCont DROP FOREIGN KEY FK_6786D1A6CA98095F');
        $this->addSql(' ALTER TABLE tb_Tiers DROP FOREIGN KEY FK_BD6D4456FA5A8103');
        $this->addSql(' ALTER TABLE tb_Session DROP FOREIGN KEY FK_602E36EAE56FA7E5');

        $this->addSql('ALTER TABLE tb_CiviliteT CHANGE cty_ID cty_ID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tb_FormationT CHANGE fty_ID fty_ID TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tb_ModuleT CHANGE mty_ID mty_ID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tb_Session CHANGE ses_SType ses_SType TINYINT(1) NOT NULL, CHANGE ses_FType ses_FType TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tb_SessionT CHANGE sty_ID sty_ID TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tb_SortieT CHANGE srt_ID srt_ID INT AUTO_INCREMENT NOT NULL');

        $this->addSql(' ALTER TABLE tb_Parcours ADD CONSTRAINT FK_5860A9AB8B0E8D1E FOREIGN KEY (prc_Type) REFERENCES tb_ModuleT(mty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EA3ABF8E06 FOREIGN KEY (ses_MType) REFERENCES tb_ModuleT(mty_ID)');
        $this->addSql(' ALTER TABLE tb_DParcours ADD CONSTRAINT FK_9AA5BF0F2CEA72D8 FOREIGN KEY (dpr_Type) REFERENCES tb_ModuleT(fty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EA4D6FBF17 FOREIGN KEY (ses_FType) REFERENCES tb_FormationT(fty_ID)');
        $this->addSql(' ALTER TABLE tb_DCont ADD CONSTRAINT FK_6786D1A6CA98095F FOREIGN KEY (cnt_MotifSortie) REFERENCES tb_SortieT(srt_ID)');
        $this->addSql(' ALTER TABLE tb_Tiers ADD CONSTRAINT FK_BD6D4456FA5A8103 FOREIGN KEY (trs_Civilite) REFERENCES tb_CiviliteT(cty_ID)');
        $this->addSql(' ALTER TABLE tb_Session ADD CONSTRAINT FK_602E36EAE56FA7E5 FOREIGN KEY (ses_SType) REFERENCES tb_SessionT(sty_ID)');
    }
}
