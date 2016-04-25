<?php

namespace CEOFESABundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CEOFESABundle\Validator\Constraints as CeofesaAssert;

/**
 * DAF (Devis validé)
 *
 * @ORM\Table(name="tb_DAF", indexes={@ORM\Index(name="daf_Dossier", columns={"daf_Dossier"}), @ORM\Index(name="daf_DDebut", columns={"daf_DateDebut"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\DAFRepository")
 */
class DAF
{
    /**
     * @var integer
     *
     * @ORM\Column(name="daf_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dafId;

    /**
     * @var string
     *
     * @ORM\Column(name="daf_Dossier", type="string", length=50, nullable=false)
     */
    private $dafDossier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daf_DateDebut", type="date", nullable=false)
     */
    private $dafDatedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daf_DateFin", type="date", nullable=false)
     */
    private $dafDatefin;

    /**
     * @var string
     *
     * @ORM\Column(name="daf_NbHeure", type="decimal", precision=10, scale=2, nullable=true, options={"default" = 0.00})
     */
    private $dafNbheure;

    /**
     * @var integer
     *
     * @ORM\Column(name="daf_NbSalarie", type="integer", nullable=true, options={"default" = 0})
     */
    private $dafNbsalarie;

    /**
     * @var string
     *
     * @ORM\Column(name="daf_Montant", type="decimal", precision=10, scale=2, nullable=true, options={"default" = 0.00})
     */
    private $dafMontant;

    /**
     * @var string
     *
     * @ORM\Column(name="daf_TauxHoraire", type="decimal", precision=10, scale=2, nullable=true, options={"default" = 0.00})
     */
    private $dafTauxhoraire;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(
     *     name                 = "daf_Structure",
     *     referencedColumnName = "str_ID",
     *     nullable             = false
     * )
     * })
     */
    private $dafStructure;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(
     *     name                 = "daf_OF",
     *     referencedColumnName = "str_ID",
     *     nullable             = false
     * )
     * })
     */
    private $dafOf;

    /**
     * @var DCont
     *
     * @ORM\OneToMany(
     *     targetEntity = "CEOFESABundle\Entity\DCont",
     *     mappedBy     = "cntDaf",
     *     cascade      = {"persist"}
     * )
     */
    private $dafDcont;

    /**
     * @var DCont
     *
     * @ORM\OneToMany(
     *     targetEntity  = "CEOFESABundle\Entity\BonCde",
     *     mappedBy      = "bcdDAF",
     *     cascade       = {"persist"}
     * )
     */
    private $bcdBonCdes;

    /**
     * DAF constructor.
     */
    public function __construct()
    {
        $this->dafDcont = new ArrayCollection();
        $this->bcdBonCdes = new ArrayCollection();
    }

    /**
     * Get dafId
     *
     * @return integer
     */
    public function getDafId()
    {
        return $this->dafId;
    }

    /**
     * Set dafDossier
     *
     * @param string $dafDossier
     * @return DAF
     */
    public function setDafDossier($dafDossier)
    {
        $this->dafDossier = $dafDossier;

        return $this;
    }

    /**
     * Get dafDossier
     *
     * @return string
     */
    public function getDafDossier()
    {
        return $this->dafDossier;
    }

    /**
     * Set dafDatedebut
     *
     * @param \DateTime $dafDatedebut
     * @return DAF
     */
    public function setDafDatedebut($dafDatedebut)
    {
        $this->dafDatedebut = $dafDatedebut;

        return $this;
    }

    /**
     * Get dafDatedebut
     *
     * @return \DateTime
     */
    public function getDafDatedebut()
    {
        return $this->dafDatedebut;
    }

    /**
     * Set dafDatefin
     *
     * @param \DateTime $dafDatefin
     * @return DAF
     */
    public function setDafDatefin($dafDatefin)
    {
        $this->dafDatefin = $dafDatefin;

        return $this;
    }

    /**
     * Get dafDatefin
     *
     * @return \DateTime
     */
    public function getDafDatefin()
    {
        return $this->dafDatefin;
    }

    /**
     * Set dafNbheure
     *
     * @param string $dafNbheure
     * @return DAF
     */
    public function setDafNbheure($dafNbheure)
    {
        $this->dafNbheure = $dafNbheure;

        return $this;
    }

    /**
     * Get dafNbheure
     *
     * @return string
     */
    public function getDafNbheure()
    {
        return $this->dafNbheure;
    }

    /**
     * Set dafNbsalarie
     *
     * @param integer $dafNbsalarie
     * @return DAF
     */
    public function setDafNbsalarie($dafNbsalarie)
    {
        $this->dafNbsalarie = $dafNbsalarie;

        return $this;
    }

    /**
     * Get dafNbsalarie
     *
     * @return integer
     */
    public function getDafNbsalarie()
    {
        return $this->dafNbsalarie;
    }

    /**
     * Set dafMontant
     *
     * @param string $dafMontant
     * @return DAF
     */
    public function setDafMontant($dafMontant)
    {
        $this->dafMontant = $dafMontant;

        return $this;
    }

    /**
     * Get dafMontant
     *
     * @return string
     */
    public function getDafMontant()
    {
        return $this->dafMontant;
    }

    /**
     * Set dafTauxhoraire
     *
     * @param string $dafTauxhoraire
     * @return DAF
     */
    public function setDafTauxhoraire($dafTauxhoraire)
    {
        $this->dafTauxhoraire = $dafTauxhoraire;

        return $this;
    }

    /**
     * Get dafTauxhoraire
     *
     * @return string
     */
    public function getDafTauxhoraire()
    {
        return $this->dafTauxhoraire;
    }

    /**
     * Set dafStructure
     *
     * @param \CEOFESABundle\Entity\Structure $dafStructure
     * @return DAF
     */
    public function setDafStructure(\CEOFESABundle\Entity\Structure $dafStructure = null)
    {
        $this->dafStructure = $dafStructure;

        return $this;
    }

    /**
     * Get dafStructure
     *
     * @return \CEOFESABundle\Entity\Structure
     */
    public function getDafStructure()
    {
        return $this->dafStructure;
    }

    /**
     * Set dafOf
     *
     * @param \CEOFESABundle\Entity\Structure $dafOf
     * @return DAF
     */
    public function setDafOf(\CEOFESABundle\Entity\Structure $dafOf = null)
    {
        $this->dafOf = $dafOf;

        return $this;
    }

    /**
     * Get dafOf
     *
     * @return \CEOFESABundle\Entity\Structure
     */
    public function getDafOf()
    {
        return $this->dafOf;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\CEOFESABundle\Entity\DCont[]
     */
    public function getDafDcont()
    {
        return $this->dafDcont;
    }

    /**
     * @param DCont $dafDcont
     * @return DAF
     */
    public function addDafDcont(DCont $dafDcont)
    {
        $this->dafDcont[] = $dafDcont;
        $dafDcont->setCntDaf($this);

        return $this;
    }

    /**
     * @param DCont $dafDcont
     * @return $this
     */
    public function removeDafDcont(DCont $dafDcont)
    {
        $this->dafDcont->removeElement($dafDcont);
        return $this;
    }

    /**
     * @return int
     */
    public function calcNbSalarie()
    {
        $tab = array();

        foreach ($this->getDafDcont() as $dcont) {
            $tab[$dcont->getCntTiers()->getTrsId()] = true;
        }

        return count($tab);
    }

    /**
     * @return int
     */
    public function calcNbheure()
    {
        $ret = 0;

        $dcont = $this->getDafDcont()->first();

        foreach ($dcont->getCntParcours() as $parcours) {
            $ret += $parcours->getPrcNombreheure();
        }

        return $ret;
    }

    /**
     * @param Tiers $tiers
     * @return DCont|null
     */
    public function getTiersDCont(Tiers $tiers)
    {
        $DCont = null;

        if ($this->getDafDcont() != null)  {
            foreach ($this->getDafDcont() as $dcont) {
                if ($dcont->getCntTiers() and $dcont->getCntTiers()->getTrsId() == $tiers->getTrsId()) {
                    $DCont = $dcont;
                }
            }
        }

        if ($DCont == null) {
            $DCont = new DCont();
            $this->addDafDcont($DCont);
        }

        $DCont->setCntTiers($tiers);

        return $DCont;
    }

    /**
     * @return float
     */
    public function calcMontant()
    {
        return $this->getDafNbHeure() * $this->getDafTauxhoraire() * $this->getDafNbsalarie();
    }

    /**
     * @param Devis $devis
     */
    public function createFromDevis(Devis $devis)
    {
        $this->setDafDatedebut($devis->getDevDatedebut());
        $this->setDafDatefin($devis->getDevDatefin());

        foreach ($devis->getDevParcours() as $dParcour) {
            $DCont = $this->getTiersDCont($dParcour->getDprTiers());

            $parcours = new Parcours();
            $parcours->setPrcModule($dParcour->getDprModule());
            $parcours->setPrcNombreheure($dParcour->getDprNombreheure());
            $parcours->setPrcStructure($dParcour->getDprStructure());
            $parcours->setPrcType($dParcour->getDprType());
            $parcours->setPrcDcont($DCont);

            $DCont->addCntParcour($parcours);
        }

        return ;
    }

}
