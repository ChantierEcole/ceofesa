<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CEOFESABundle\Validator\Constraints as CeofesaAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Devis
 *
 * @ORM\Table(name="tb_Devis", uniqueConstraints={@ORM\UniqueConstraint(name="unq_devis", columns={"dev_Annee", "dev_Numero", "dev_OF"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\DevisRepository")
 * @CeofesaAssert\DateRange
 */
class Devis
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dev_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $devId;

    /**
     * @var string
     *
     * @ORM\Column(name="dev_Annee", type="string", length=4, nullable=false)
     */
    private $devAnnee;

    /**
     * @var integer
     *
     * @ORM\Column(name="dev_Numero", type="integer", nullable=true, options={"default" = 0})
     */
    private $devNumero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dev_DateDevis", type="datetime", nullable=false)
     */
    private $devDatedevis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dev_DateDebut", type="datetime", nullable=false)
     */
    private $devDatedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dev_DateFin", type="datetime", nullable=false)
     */
    private $devDatefin;

    /**
     * @var decimal
     *
     * @ORM\Column(name="dev_TauxHoraire", type="decimal", precision=10, scale=2, nullable=true, options={"default" = 0.00})
     */
    private $devTauxhoraire;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dev_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $devStructure;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dev_OF", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $devOf;

    /**
    * @ORM\OneToMany(targetEntity="DParcours", mappedBy="dprDevis", cascade={"persist"}, orphanRemoval=true)
    * @Assert\Valid
    * @CeofesaAssert\Parcours
    */
    protected $devParcours;

    /**
     * @var string
     *
     * @ORM\Column(name="dev_Statut", type="string", length=20, nullable=false, options={"default" = "en cours"})
     */
    private $devStatut = 'en cours';


    public function __construct()
    {
        $this->devParcours = new ArrayCollection();
    }

    /**
     * Get devId
     *
     * @return integer 
     */
    public function getDevId()
    {
        return $this->devId;
    }

    /**
     * Set devAnnee
     *
     * @param string $devAnnee
     * @return Devis
     */
    public function setDevAnnee($devAnnee)
    {
        $this->devAnnee = $devAnnee;

        return $this;
    }

    /**
     * Get devAnnee
     *
     * @return string 
     */
    public function getDevAnnee()
    {
        return $this->devAnnee;
    }

    /**
     * Set devNumero
     *
     * @param integer $devNumero
     * @return Devis
     */
    public function setDevNumero($devNumero)
    {
        $this->devNumero = $devNumero;

        return $this;
    }

    /**
     * Get devNumero
     *
     * @return integer 
     */
    public function getDevNumero()
    {
        return $this->devNumero;
    }

    /**
     * Set devDatedevis
     *
     * @param \DateTime $devDatedevis
     * @return Devis
     */
    public function setDevDatedevis($devDatedevis)
    {
        $this->devDatedevis = $devDatedevis;

        return $this;
    }

    /**
     * Get devDatedevis
     *
     * @return \DateTime 
     */
    public function getDevDatedevis()
    {
        return $this->devDatedevis;
    }

    /**
     * Set devDatedebut
     *
     * @param \DateTime $devDatedebut
     * @return Devis
     */
    public function setDevDatedebut($devDatedebut)
    {
        $this->devDatedebut = $devDatedebut;

        return $this;
    }

    /**
     * Get devDatedebut
     *
     * @return \DateTime 
     */
    public function getDevDatedebut()
    {
        return $this->devDatedebut;
    }

    /**
     * Set devDatefin
     *
     * @param \DateTime $devDatefin
     * @return Devis
     */
    public function setDevDatefin($devDatefin)
    {
        $this->devDatefin = $devDatefin;

        return $this;
    }

    /**
     * Get devDatefin
     *
     * @return \DateTime 
     */
    public function getDevDatefin()
    {
        return $this->devDatefin;
    }

    /**
     * Set devTauxhoraire
     *
     * @param string $devTauxhoraire
     * @return Devis
     */
    public function setDevTauxhoraire($devTauxhoraire)
    {
        $this->devTauxhoraire = $devTauxhoraire;

        return $this;
    }

    /**
     * Get devTauxhoraire
     *
     * @return string 
     */
    public function getDevTauxhoraire()
    {
        return $this->devTauxhoraire;
    }

    /**
     * Set devStructure
     *
     * @param \CEOFESABundle\Entity\Structure $devStructure
     * @return Devis
     */
    public function setDevStructure(\CEOFESABundle\Entity\Structure $devStructure = null)
    {
        $this->devStructure = $devStructure;

        return $this;
    }

    /**
     * Get devStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getDevStructure()
    {
        return $this->devStructure;
    }

    /**
     * Set devOf
     *
     * @param \CEOFESABundle\Entity\Structure $devOf
     * @return Devis
     */
    public function setDevOf(\CEOFESABundle\Entity\Structure $devOf = null)
    {
        $this->devOf = $devOf;

        return $this;
    }

    /**
     * Get devOf
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getDevOf()
    {
        return $this->devOf;
    }

    /**
     * Add devParcours
     *
     * @param \CEOFESABundle\Entity\DParcours $devParcours
     * @return Devis
     */
    public function addDevParcour(\CEOFESABundle\Entity\DParcours $devParcours)
    {
        $devParcours->setDprDevis($this);
        $this->devParcours[] = $devParcours;

        return $this;
    }

    /**
     * Remove devParcours
     *
     * @param \CEOFESABundle\Entity\DParcours $devParcours
     */
    public function removeDevParcour(\CEOFESABundle\Entity\DParcours $devParcours)
    {
        $this->devParcours->removeElement($devParcours);
    }

    /**
     * Get devParcours
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDevParcours()
    {
        return $this->devParcours;
    }

    /**
     * Set devStatut
     *
     * @param string $devStatut
     * @return Devis
     */
    public function setDevStatut($devStatut)
    {
        $this->devStatut = $devStatut;

        return $this;
    }

    /**
     * Get devStatut
     *
     * @return string 
     */
    public function getDevStatut()
    {
        return $this->devStatut;
    }

    /**
    * Get Prix total d'un Devis
    *
    * @return string
    */
    public function getDevPrixTotal()
    {
        $prix = 0;
        foreach($this->getDevParcours() as $parcour)
        {
            $prix += $parcour->getDprNombreheure() * $this->getDevTauxhoraire();
        }
        return $prix;
    }
}
