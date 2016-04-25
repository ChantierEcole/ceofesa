<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CEOFESABundle\Validator\Constraints as CeofesaAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tiers
 *
 * @ORM\Table(name="tb_Tiers", indexes={@ORM\Index(name="trs_CP", columns={"trs_CP"}), @ORM\Index(name="trs_Structure", columns={"trs_Structure"}), @ORM\Index(name="trs_Nom", columns={"trs_Nom"}), @ORM\Index(name="trs_Nom_Prenom", columns={"trs_Nom", "trs_Prenom"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\TiersRepository")
 * @UniqueEntity(fields="trsNumsecu", message="L'utilisateur avec le numéro de sécurité sociale indiqué est déjà enregistré.")
 * @UniqueEntity(fields={"trsNom","trsPrenom","trsCp"}, message="L'utilisateur semble déjà enregistré. Si vous souhaitez enregistrer un stagiaire avec le même nom, prénom et CP qu'un autre, merci de nous contacter")
 */
class Tiers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="trs_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $trsId;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Nom", type="string", length=30, nullable=true)
     * @Assert\NotBlank()
     */
    private $trsNom;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Prenom", type="string", length=30, nullable=true)
     * @Assert\NotBlank()
     */
    private $trsPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Adresse1", type="string", length=40, nullable=true)
     * @Assert\NotBlank()
     */
    private $trsAdresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Adresse2", type="string", length=40, nullable=true)
     */
    private $trsAdresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_CP", type="string", length=5, nullable=true)
     * @Assert\Type(type="numeric", message="Ce champ ne doit contenir que des nombres")
     * @Assert\Length(min=5,max=5)
     * @Assert\NotBlank()
     */
    private $trsCp;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Ville", type="string", length=34, nullable=true)
     * @Assert\NotBlank()
     */
    private $trsVille;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Tel1", type="string", length=14, nullable=true)
     */
    private $trsTel1;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Tel2", type="string", length=14, nullable=true)
     */
    private $trsTel2;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Portable", type="string", length=14, nullable=true)
     */
    private $trsPortable;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Email", type="string", length=50, nullable=true)
     */
    private $trsEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_Fonction", type="string", length=25, nullable=true)
     */
    private $trsFonction;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trs_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $trsStructure;

    /**
     * @var TiersT
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\TiersT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trs_Type", referencedColumnName="tty_ID", nullable=false)
     * })
     */
    private $trsType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="trs_DateNaissance", type="date", nullable=true)
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $trsDatenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_LieuNaissance", type="string", length=45, nullable=true)
     */
    private $trsLieunaissance;

    /**
     * @var CiviliteT
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\CiviliteT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trs_Civilite", referencedColumnName="cty_ID")
     * })
     */
    private $trsCivilite;

    /**
     * @var string
     *
     * @ORM\Column(name="trs_NumSecu", type="string", length=45, nullable=true)
     * @Assert\Regex(pattern="/^[\d ]*$/", message="Ce champ ne doit contenir que des nombres")
     * @Assert\Length(min=13,max=21)
     * @CeofesaAssert\Numsecu(groups={"formateur"})
     */
    private $trsNumsecu;

    /**
     * Get trsId
     *
     * @return integer 
     */
    public function getTrsId()
    {
        return $this->trsId;
    }

    /**
     * Set trsNom
     *
     * @param string $trsNom
     * @return Tiers
     */
    public function setTrsNom($trsNom)
    {
        $this->trsNom = $trsNom;

        return $this;
    }

    /**
     * Get trsNom
     *
     * @return string 
     */
    public function getTrsNom()
    {
        return $this->trsNom;
    }

    /**
     * Set trsPrenom
     *
     * @param string $trsPrenom
     * @return Tiers
     */
    public function setTrsPrenom($trsPrenom)
    {
        $this->trsPrenom = $trsPrenom;

        return $this;
    }

    /**
     * Get trsPrenom
     *
     * @return string 
     */
    public function getTrsPrenom()
    {
        return $this->trsPrenom;
    }

    /**
     * Set trsAdresse1
     *
     * @param string $trsAdresse1
     * @return Tiers
     */
    public function setTrsAdresse1($trsAdresse1)
    {
        $this->trsAdresse1 = $trsAdresse1;

        return $this;
    }

    /**
     * Get trsAdresse1
     *
     * @return string 
     */
    public function getTrsAdresse1()
    {
        return $this->trsAdresse1;
    }

    /**
     * Set trsAdresse2
     *
     * @param string $trsAdresse2
     * @return Tiers
     */
    public function setTrsAdresse2($trsAdresse2)
    {
        $this->trsAdresse2 = $trsAdresse2;

        return $this;
    }

    /**
     * Get trsAdresse2
     *
     * @return string 
     */
    public function getTrsAdresse2()
    {
        return $this->trsAdresse2;
    }

    /**
     * Set trsCp
     *
     * @param string $trsCp
     * @return Tiers
     */
    public function setTrsCp($trsCp)
    {
        $this->trsCp = $trsCp;

        return $this;
    }

    /**
     * Get trsCp
     *
     * @return string 
     */
    public function getTrsCp()
    {
        return $this->trsCp;
    }

    /**
     * Set trsVille
     *
     * @param string $trsVille
     * @return Tiers
     */
    public function setTrsVille($trsVille)
    {
        $this->trsVille = $trsVille;

        return $this;
    }

    /**
     * Get trsVille
     *
     * @return string 
     */
    public function getTrsVille()
    {
        return $this->trsVille;
    }

    /**
     * Set trsTel1
     *
     * @param string $trsTel1
     * @return Tiers
     */
    public function setTrsTel1($trsTel1)
    {
        $this->trsTel1 = $trsTel1;

        return $this;
    }

    /**
     * Get trsTel1
     *
     * @return string 
     */
    public function getTrsTel1()
    {
        return $this->trsTel1;
    }

    /**
     * Set trsTel2
     *
     * @param string $trsTel2
     * @return Tiers
     */
    public function setTrsTel2($trsTel2)
    {
        $this->trsTel2 = $trsTel2;

        return $this;
    }

    /**
     * Get trsTel2
     *
     * @return string 
     */
    public function getTrsTel2()
    {
        return $this->trsTel2;
    }

    /**
     * Set trsPortable
     *
     * @param string $trsPortable
     * @return Tiers
     */
    public function setTrsPortable($trsPortable)
    {
        $this->trsPortable = $trsPortable;

        return $this;
    }

    /**
     * Get trsPortable
     *
     * @return string 
     */
    public function getTrsPortable()
    {
        return $this->trsPortable;
    }

    /**
     * Set trsEmail
     *
     * @param string $trsEmail
     * @return Tiers
     */
    public function setTrsEmail($trsEmail)
    {
        $this->trsEmail = $trsEmail;

        return $this;
    }

    /**
     * Get trsEmail
     *
     * @return string 
     */
    public function getTrsEmail()
    {
        return $this->trsEmail;
    }

    /**
     * Set trsFonction
     *
     * @param string $trsFonction
     * @return Tiers
     */
    public function setTrsFonction($trsFonction)
    {
        $this->trsFonction = $trsFonction;

        return $this;
    }

    /**
     * Get trsFonction
     *
     * @return string 
     */
    public function getTrsFonction()
    {
        return $this->trsFonction;
    }

    /**
     * Set trsDatenaissance
     *
     * @param \DateTime $trsDatenaissance
     * @return Tiers
     */
    public function setTrsDatenaissance($trsDatenaissance)
    {
        $this->trsDatenaissance = $trsDatenaissance;

        return $this;
    }

    /**
     * Get trsDatenaissance
     *
     * @return \DateTime 
     */
    public function getTrsDatenaissance()
    {
        return $this->trsDatenaissance;
    }

    /**
     * Set trsLieunaissance
     *
     * @param string $trsLieunaissance
     * @return Tiers
     */
    public function setTrsLieunaissance($trsLieunaissance)
    {
        $this->trsLieunaissance = $trsLieunaissance;

        return $this;
    }

    /**
     * Get trsLieunaissance
     *
     * @return string 
     */
    public function getTrsLieunaissance()
    {
        return $this->trsLieunaissance;
    }

    /**
     * Set trsNumsecu
     *
     * @param string $trsNumsecu
     * @return Tiers
     */
    public function setTrsNumsecu($trsNumsecu)
    {
        $this->trsNumsecu = $trsNumsecu;

        return $this;
    }

    /**
     * Get trsNumsecu
     *
     * @return string 
     */
    public function getTrsNumsecu()
    {
        return $this->trsNumsecu;
    }

    /**
     * Set trsStructure
     *
     * @param \CEOFESABundle\Entity\Structure $trsStructure
     * @return Tiers
     */
    public function setTrsStructure(\CEOFESABundle\Entity\Structure $trsStructure)
    {
        $this->trsStructure = $trsStructure;

        return $this;
    }

    /**
     * Get trsStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getTrsStructure()
    {
        return $this->trsStructure;
    }

    /**
     * Set trsType
     *
     * @param \CEOFESABundle\Entity\Tierst $trsType
     * @return Tiers
     */
    public function setTrsType(\CEOFESABundle\Entity\Tierst $trsType)
    {
        $this->trsType = $trsType;

        return $this;
    }

    /**
     * Get trsType
     *
     * @return \CEOFESABundle\Entity\Tierst 
     */
    public function getTrsType()
    {
        return $this->trsType;
    }

    /**
     * Set trsCivilite
     *
     * @param \CEOFESABundle\Entity\CiviliteT $trsCivilite
     * @return Tiers
     */
    public function setTrsCivilite(\CEOFESABundle\Entity\CiviliteT $trsCivilite = null)
    {
        $this->trsCivilite = $trsCivilite;

        return $this;
    }

    /**
     * Get trsCivilite
     *
     * @return \CEOFESABundle\Entity\CiviliteT 
     */
    public function getTrsCivilite()
    {
        return $this->trsCivilite;
    }



    /**
     * Get trsNomPrenom
     *
     * @return string
     */
    public function getTrsNomPrenom()
    {
        return $this->trsNom.' '.$this->trsPrenom;
    }
}
