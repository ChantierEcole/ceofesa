<?php

namespace CEOFESABundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CEOFESABundle\Validator\Constraints as CeofesaAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Structure
 *
 * @ORM\Table(name="tb_Structure", options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\StructureRepository")
 * @UniqueEntity(fields="strSiret", message="L'Organisme de Formation avec le numéro SIRET indiqué est déjà enregistré.")
 */
class Structure
{
    const TYPE_STRUCTURE        = 1;
    const TYPE_OF_PRINCIPAL     = 2;
    const TYPE_OF_SOUSTRAITANT  = 3;

    const OFESA_ID = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="str_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $strId;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Nom", type="string", length=50, nullable=true)
     * @Assert\NotBlank()
     */
    private $strNom;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Adresse1", type="string", length=40, nullable=true)
     */
    private $strAdresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Adresse2", type="string", length=40, nullable=true)
     */
    private $strAdresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="str_CP", type="string", length=5, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric", message="Ce champ ne doit contenir que des nombres")
     * @Assert\Length(min=5,max=5)
     */
    private $strCp;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Ville", type="string", length=34, nullable=true)
     * @Assert\NotBlank()
     */
    private $strVille;

    /**
     * @var string
     *
     * @ORM\Column(name="str_INCOM", type="string", length=8, nullable=true)
     */
    private $strIncom;

    /**
     * @var string
     *
     * @ORM\Column(name="str_SIRET", type="string", length=14, nullable=true)
     * @Assert\NotBlank()
     * @CeofesaAssert\NumSiret
     * @Assert\Length(min=14,max=14)
     */
    private $strSiret;

    /**
     * @var string
     *
     * @ORM\Column(name="str_NumOF", type="string", length=20, nullable=true)
     */
    private $strNumof;

    /**
     * @var boolean
     *
     * @ORM\Column(name="str_Adherent", type="boolean", nullable=true, options={"default" = 0})
     */
    private $strAdherent;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="str_Region", referencedColumnName="reg_ID")
     * })
     */
    private $strRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="str_telephone", type="string", length=14, nullable=true)
     */
    private $strTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="str_EMail", type="string", length=50, nullable=true)
     */
    private $strEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="str_EnvoiConvention", type="boolean", nullable=true, options={"default" = 0})
     */
    private $strEnvoiconvention;

    /**
     * @var boolean
     *
     * @ORM\Column(name="str_EnvoiAvenant", type="boolean", nullable=true, options={"default" = 0})
     */
    private $strEnvoiavenant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="str_RetourConvention", type="boolean", nullable=true, options={"default" = 0})
     */
    private $strRetourconvention;

    /**
     * @var boolean
     *
     * @ORM\Column(name="str_RetourAvenant", type="boolean", nullable=true, options={"default" = 0})
     */
    private $strRetouravenant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateAgrement", type="datetime", nullable=true)
     */
    private $strDateagrement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateFin", type="datetime", nullable=true)
     */
    private $strDatefin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateEnvoiConvention", type="datetime", nullable=true)
     */
    private $strDateenvoiconvention;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateRetourConvention", type="datetime", nullable=true)
     */
    private $strDateretourconvention;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateEnvoiAvenant", type="datetime", nullable=true)
     */
    private $strDateenvoiavenant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="str_DateRetourAvenant", type="datetime", nullable=true)
     */
    private $strDateretouravenant;

    /**
     * @var StructureT
     *
     * @ORM\ManyToOne(targetEntity="CEOFESABundle\Entity\StructureT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="str_Type", referencedColumnName="sty_ID", nullable=false)
     * })
     */
    private $strType;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Reponsable", type="string", length=45, nullable=true)
     */
    private $strReponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="str_Fonction", type="string", length=45, nullable=true)
     */
    private $strFonction;

    /**
     * @var Relation
     *
     * @ORM\OneToMany(targetEntity="CEOFESABundle\Entity\Relation", mappedBy="relStructure")
     */
    private $strRelations;

    /**
     * @var Parcours
     *
     * @ORM\OneToMany(targetEntity="CEOFESABundle\Entity\Parcours", mappedBy="prcStructure")
     */
    private $strParcours;

    /**
     * Structure constructor.
     */
    public function __construct()
    {
        $this->strRelations = new ArrayCollection();
        $this->strParcours = new ArrayCollection();
    }

    /**
     * Get strId
     *
     * @return integer
     */
    public function getStrId()
    {
        return $this->strId;
    }

    /**
     * Set strNom
     *
     * @param string $strNom
     * @return Structure
     */
    public function setStrNom($strNom)
    {
        $this->strNom = $strNom;

        return $this;
    }

    /**
     * Get strNom
     *
     * @return string
     */
    public function getStrNom()
    {
        return $this->strNom;
    }

    /**
     * Set strAdresse1
     *
     * @param string $strAdresse1
     * @return Structure
     */
    public function setStrAdresse1($strAdresse1)
    {
        $this->strAdresse1 = $strAdresse1;

        return $this;
    }

    /**
     * Get strAdresse1
     *
     * @return string
     */
    public function getStrAdresse1()
    {
        return $this->strAdresse1;
    }

    /**
     * Set strAdresse2
     *
     * @param string $strAdresse2
     * @return Structure
     */
    public function setStrAdresse2($strAdresse2)
    {
        $this->strAdresse2 = $strAdresse2;

        return $this;
    }

    /**
     * Get strAdresse2
     *
     * @return string
     */
    public function getStrAdresse2()
    {
        return $this->strAdresse2;
    }

    /**
     * Set strCp
     *
     * @param string $strCp
     * @return Structure
     */
    public function setStrCp($strCp)
    {
        $this->strCp = $strCp;

        return $this;
    }

    /**
     * Get strCp
     *
     * @return string
     */
    public function getStrCp()
    {
        return $this->strCp;
    }

    /**
     * Set strVille
     *
     * @param string $strVille
     * @return Structure
     */
    public function setStrVille($strVille)
    {
        $this->strVille = $strVille;

        return $this;
    }

    /**
     * Get strVille
     *
     * @return string
     */
    public function getStrVille()
    {
        return $this->strVille;
    }

    /**
     * Set strIncom
     *
     * @param string $strIncom
     * @return Structure
     */
    public function setStrIncom($strIncom)
    {
        $this->strIncom = $strIncom;

        return $this;
    }

    /**
     * Get strIncom
     *
     * @return string
     */
    public function getStrIncom()
    {
        return $this->strIncom;
    }

    /**
     * Set strSiret
     *
     * @param string $strSiret
     * @return Structure
     */
    public function setStrSiret($strSiret)
    {
        $this->strSiret = $strSiret;

        return $this;
    }

    /**
     * Get strSiret
     *
     * @return string
     */
    public function getStrSiret()
    {
        return $this->strSiret;
    }

    /**
     * Set strNumof
     *
     * @param string $strNumof
     * @return Structure
     */
    public function setStrNumof($strNumof)
    {
        $this->strNumof = $strNumof;

        return $this;
    }

    /**
     * Get strNumof
     *
     * @return string
     */
    public function getStrNumof()
    {
        return $this->strNumof === null ? 0 : str_replace(' ', '', $this->strNumof);
    }

    /**
     * Set strAdherent
     *
     * @param boolean $strAdherent
     * @return Structure
     */
    public function setStrAdherent($strAdherent)
    {
        $this->strAdherent = $strAdherent;

        return $this;
    }

    /**
     * Get strAdherent
     *
     * @return boolean
     */
    public function getStrAdherent()
    {
        return $this->strAdherent;
    }

    /**
     * Set strTelephone
     *
     * @param string $strTelephone
     * @return Structure
     */
    public function setStrTelephone($strTelephone)
    {
        $this->strTelephone = $strTelephone;

        return $this;
    }

    /**
     * Get strTelephone
     *
     * @return string
     */
    public function getStrTelephone()
    {
        return $this->strTelephone;
    }

    /**
     * Set strEmail
     *
     * @param string $strEmail
     * @return Structure
     */
    public function setStrEmail($strEmail)
    {
        $this->strEmail = $strEmail;

        return $this;
    }

    /**
     * Get strEmail
     *
     * @return string
     */
    public function getStrEmail()
    {
        return $this->strEmail;
    }

    /**
     * Set strEnvoiconvention
     *
     * @param boolean $strEnvoiconvention
     * @return Structure
     */
    public function setStrEnvoiconvention($strEnvoiconvention)
    {
        $this->strEnvoiconvention = $strEnvoiconvention;

        return $this;
    }

    /**
     * Get strEnvoiconvention
     *
     * @return boolean
     */
    public function getStrEnvoiconvention()
    {
        return $this->strEnvoiconvention;
    }

    /**
     * Set strEnvoiavenant
     *
     * @param boolean $strEnvoiavenant
     * @return Structure
     */
    public function setStrEnvoiavenant($strEnvoiavenant)
    {
        $this->strEnvoiavenant = $strEnvoiavenant;

        return $this;
    }

    /**
     * Get strEnvoiavenant
     *
     * @return boolean
     */
    public function getStrEnvoiavenant()
    {
        return $this->strEnvoiavenant;
    }

    /**
     * Set strRetourconvention
     *
     * @param boolean $strRetourconvention
     * @return Structure
     */
    public function setStrRetourconvention($strRetourconvention)
    {
        $this->strRetourconvention = $strRetourconvention;

        return $this;
    }

    /**
     * Get strRetourconvention
     *
     * @return boolean
     */
    public function getStrRetourconvention()
    {
        return $this->strRetourconvention;
    }

    /**
     * Set strRetouravenant
     *
     * @param boolean $strRetouravenant
     * @return Structure
     */
    public function setStrRetouravenant($strRetouravenant)
    {
        $this->strRetouravenant = $strRetouravenant;

        return $this;
    }

    /**
     * Get strRetouravenant
     *
     * @return boolean
     */
    public function getStrRetouravenant()
    {
        return $this->strRetouravenant;
    }

    /**
     * Set strDateagrement
     *
     * @param \DateTime $strDateagrement
     * @return Structure
     */
    public function setStrDateagrement($strDateagrement)
    {
        $this->strDateagrement = $strDateagrement;

        return $this;
    }

    /**
     * Get strDateagrement
     *
     * @return \DateTime
     */
    public function getStrDateagrement()
    {
        return $this->strDateagrement;
    }

    /**
     * Set strDatefin
     *
     * @param \DateTime $strDatefin
     * @return Structure
     */
    public function setStrDatefin($strDatefin)
    {
        $this->strDatefin = $strDatefin;

        return $this;
    }

    /**
     * Get strDatefin
     *
     * @return \DateTime
     */
    public function getStrDatefin()
    {
        return $this->strDatefin;
    }

    /**
     * Set strDateenvoiconvention
     *
     * @param \DateTime $strDateenvoiconvention
     * @return Structure
     */
    public function setStrDateenvoiconvention($strDateenvoiconvention)
    {
        $this->strDateenvoiconvention = $strDateenvoiconvention;

        return $this;
    }

    /**
     * Get strDateenvoiconvention
     *
     * @return \DateTime
     */
    public function getStrDateenvoiconvention()
    {
        return $this->strDateenvoiconvention;
    }

    /**
     * Set strDateretourconvention
     *
     * @param \DateTime $strDateretourconvention
     * @return Structure
     */
    public function setStrDateretourconvention($strDateretourconvention)
    {
        $this->strDateretourconvention = $strDateretourconvention;

        return $this;
    }

    /**
     * Get strDateretourconvention
     *
     * @return \DateTime
     */
    public function getStrDateretourconvention()
    {
        return $this->strDateretourconvention;
    }

    /**
     * Set strDateenvoiavenant
     *
     * @param \DateTime $strDateenvoiavenant
     * @return Structure
     */
    public function setStrDateenvoiavenant($strDateenvoiavenant)
    {
        $this->strDateenvoiavenant = $strDateenvoiavenant;

        return $this;
    }

    /**
     * Get strDateenvoiavenant
     *
     * @return \DateTime
     */
    public function getStrDateenvoiavenant()
    {
        return $this->strDateenvoiavenant;
    }

    /**
     * Set strDateretouravenant
     *
     * @param \DateTime $strDateretouravenant
     * @return Structure
     */
    public function setStrDateretouravenant($strDateretouravenant)
    {
        $this->strDateretouravenant = $strDateretouravenant;

        return $this;
    }

    /**
     * Get strDateretouravenant
     *
     * @return \DateTime
     */
    public function getStrDateretouravenant()
    {
        return $this->strDateretouravenant;
    }

    /**
     * Set strReponsable
     *
     * @param string $strReponsable
     * @return Structure
     */
    public function setStrReponsable($strReponsable)
    {
        $this->strReponsable = $strReponsable;

        return $this;
    }

    /**
     * Get strReponsable
     *
     * @return string
     */
    public function getStrReponsable()
    {
        return $this->strReponsable;
    }

    /**
     * Set strFonction
     *
     * @param string $strFonction
     * @return Structure
     */
    public function setStrFonction($strFonction)
    {
        $this->strFonction = $strFonction;

        return $this;
    }

    /**
     * Get strFonction
     *
     * @return string
     */
    public function getStrFonction()
    {
        return $this->strFonction;
    }

    /**
     * Set strRegion
     *
     * @param \CEOFESABundle\Entity\Region $strRegion
     * @return Structure
     */
    public function setStrRegion(\CEOFESABundle\Entity\Region $strRegion = null)
    {
        $this->strRegion = $strRegion;

        return $this;
    }

    /**
     * Get strRegion
     *
     * @return \CEOFESABundle\Entity\Region
     */
    public function getStrRegion()
    {
        return $this->strRegion;
    }

    /**
     * Set strType
     *
     * @param \CEOFESABundle\Entity\StructureT $strType
     * @return Structure
     */
    public function setStrType(\CEOFESABundle\Entity\StructureT $strType = null)
    {
        $this->strType = $strType;

        return $this;
    }

    /**
     * Get strType
     *
     * @return \CEOFESABundle\Entity\StructureT
     */
    public function getStrType()
    {
        return $this->strType;
    }

    /**
     * @return \Relation
     */
    public function getStrRelations()
    {
        return $this->strRelations;
    }

    /**
     * @param \Relation $strRelations
     */
    public function setStrRelations($strRelations)
    {
        $this->strRelations = $strRelations;
    }

    /**
     * @return Parcours
     */
    public function getStrParcours()
    {
        return $this->strParcours;
    }

    /**
     * @param Parcours $strParcours
     */
    public function setStrParcours($strParcours)
    {
        $this->strParcours = $strParcours;
    }

    public function __toString()
    {
        return (string) $this->getStrNom();
    }
}
