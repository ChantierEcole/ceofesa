<?php

namespace CEOFESABundle\Entity;

use CEOFESABundle\Validator\Constraints as CeofesaAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Session
 *
 * @ORM\Table(name="tb_Session")
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\SessionRepository")
 *
 * @CeofesaAssert\Session
 *
 * @Gedmo\SoftDeleteable(fieldName = "deletedAt")
 */
class Session
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ses_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sesId;

    /**
     * @var \CEOFESABundle\Entity\Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $sesStructure;

    /**
     * @var \CEOFESABundle\Entity\Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_OF", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $sesOf;

    /**
     * @var \CEOFESABundle\Entity\ModuleT
     *
     * @ORM\ManyToOne(targetEntity="ModuleT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_MType", referencedColumnName="mty_ID", nullable=false)
     * })
     */
    private $sesMtype = "0";

    /**
     * @var \CEOFESABundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_Module", referencedColumnName="mod_ID", nullable=false)
     * })
     */
    private $sesModule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ses_Date", type="date", nullable=false)
     */
    private $sesDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ses_HeureDebut", type="string", length=5, nullable=false)
     */
    private $sesHeuredebut;

    /**
     * @var string
     *
     * @ORM\Column(name="ses_HeureFin", type="string", length=5, nullable=false)
     */
    private $sesHeurefin;

    /**
     * @var string
     *
     * @ORM\Column(name="ses_Duree", type="decimal", precision=5, scale=2, nullable=false, options={"default" = 0.00})
     */
    private $sesDuree = '0.00';

    /**
     * @var \CEOFESABundle\Entity\SessionT
     *
     * @ORM\ManyToOne(targetEntity="SessionT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_SType", referencedColumnName="sty_ID", nullable=false)
     * })
     */
    private $sesStype = '0';

    /**
     * @var \CEOFESABundle\Entity\FormationT
     *
     * @ORM\ManyToOne(targetEntity="FormationT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_FType", referencedColumnName="fty_ID", nullable=false)
     * })
     */
    private $sesFtype = '0';

    /**
     * @var \CEOFESABundle\Entity\Animation
     *
     * @ORM\OneToMany(targetEntity="Animation", mappedBy="aniSession")
     */
    private $sesAnimations;

    /**
     * @var \CEOFESABundle\Entity\Presence[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\CEOFESABundle\Entity\Presence", mappedBy="pscSession")
     */
    private $presences;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name     = "deleted_at",
     *     type     = "datetime",
     *     nullable = true
     * )
     */
    private $deletedAt;

    /**
     * @var \CEOFESABundle\Entity\Tiers
     *
     * @Assert\NotNull(
     *     message = "Vous devez choisir un formateur"
     * )
     */
    private $formateur;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    /**
     * Get sesId
     *
     * @return integer
     */
    public function getSesId()
    {
        return $this->sesId;
    }

    /**
     * Set sesDate
     *
     * @param \DateTime $sesDate
     * @return Session
     */
    public function setSesDate($sesDate)
    {
        $this->sesDate = $sesDate;

        return $this;
    }

    /**
     * Get sesDate
     *
     * @return \DateTime
     */
    public function getSesDate()
    {
        return $this->sesDate;
    }

    /**
     * @param string $sesHeuredebut
     *
     * @return Session
     */
    public function setSesHeuredebut($sesHeuredebut)
    {
        $this->sesHeuredebut = $sesHeuredebut;

        return $this;
    }

    /**
     * @return string
     */
    public function getSesHeuredebut()
    {
        return $this->sesHeuredebut;
    }

    /**
     * @param string $sesHeurefin
     *
     * @return Session
     */
    public function setSesHeurefin($sesHeurefin)
    {
        $this->sesHeurefin = $sesHeurefin;

        return $this;
    }

    /**
     * @return string
     */
    public function getSesHeurefin()
    {
        return $this->sesHeurefin;
    }

    /**
     * @param string $sesDuree
     *
     * @return Session
     */
    public function setSesDuree($sesDuree)
    {
        $this->sesDuree = $sesDuree;

        return $this;
    }

    /**
     * @return string
     */
    public function getSesDuree()
    {
        return $this->sesDuree;
    }

    /**
     * @param \CEOFESABundle\Entity\ModuleT $sesMtype
     *
     * @return Session
     */
    public function setSesMtype(ModuleT $sesMtype = null)
    {
        $this->sesMtype = $sesMtype;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\ModuleT
     */
    public function getSesMtype()
    {
        return $this->sesMtype;
    }

    /**
     * @param \CEOFESABundle\Entity\SessionT $sesStype
     *
     * @return Session
     */
    public function setSesStype(SessionT $sesStype = null)
    {
        $this->sesStype = $sesStype;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\SessionT
     */
    public function getSesStype()
    {
        return $this->sesStype;
    }

    /**
     * @param \CEOFESABundle\Entity\FormationT $sesFtype
     *
     * @return Session
     */
    public function setSesFtype(FormationT $sesFtype = null)
    {
        $this->sesFtype = $sesFtype;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\FormationT
     */
    public function getSesFtype()
    {
        return $this->sesFtype;
    }

    /**
     * @param \CEOFESABundle\Entity\Module $sesModule
     *
     * @return Session
     */
    public function setSesModule(Module $sesModule = null)
    {
        $this->sesModule = $sesModule;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\Module
     */
    public function getSesModule()
    {
        return $this->sesModule;
    }

    /**
     * @param \CEOFESABundle\Entity\Structure $sesStructure
     *
     * @return Session
     */
    public function setSesStructure(Structure $sesStructure = null)
    {
        $this->sesStructure = $sesStructure;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\Structure
     */
    public function getSesStructure()
    {
        return $this->sesStructure;
    }

    /**
     * @param \CEOFESABundle\Entity\Structure $sesOf
     *
     * @return Session
     */
    public function setSesOf(Structure $sesOf = null)
    {
        $this->sesOf = $sesOf;

        return $this;
    }

    /**
     * @return \CEOFESABundle\Entity\Structure
     */
    public function getSesOf()
    {
        return $this->sesOf;
    }

    /**
     * @return \CEOFESABundle\Entity\Animation
     */
    public function getSesAnimations()
    {
        return $this->sesAnimations;
    }

    /**
     * @param \CEOFESABundle\Entity\Animation $sesAnimations
     */
    public function setSesAnimations($sesAnimations)
    {
        $this->sesAnimations = $sesAnimations;
    }

    /**
     * @return \CEOFESABundle\Entity\Presence[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getPresences()
    {
        return $this->presences;
    }

    /**
     * @param \CEOFESABundle\Entity\Presence[]|\Doctrine\Common\Collections\ArrayCollection $presences
     */
    public function setPresences($presences)
    {
        $this->presences = $presences;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return \CEOFESABundle\Entity\Tiers
     */
    public function getFormateur()
    {
        return $this->formateur;
    }

    /**
     * @param \CEOFESABundle\Entity\Tiers $formateur
     */
    public function setFormateur(Tiers $formateur)
    {
        $this->formateur = $formateur;
    }
}
