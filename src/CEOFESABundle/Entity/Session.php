<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="tb_Session")
 * @ORM\Entity
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
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $sesStructure;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_OF", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $sesOf;

    /**
     * @var \ModuleT
     *
     * @ORM\ManyToOne(targetEntity="ModuleT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_MType", referencedColumnName="mty_ID", nullable=false)
     * })
     */
    private $sesMtype = "0";

    /**
     * @var \Module
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
     * @var \SessionT
     *
     * @ORM\ManyToOne(targetEntity="SessionT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_SType", referencedColumnName="sty_ID", nullable=false)
     * })
     */
    private $sesStype = '0';

    /**
     * @var \FormationT
     *
     * @ORM\ManyToOne(targetEntity="FormationT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ses_FType", referencedColumnName="fty_ID", nullable=false)
     * })
     */
    private $sesFtype = '0';



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
     * Set sesHeuredebut
     *
     * @param string $sesHeuredebut
     * @return Session
     */
    public function setSesHeuredebut($sesHeuredebut)
    {
        $this->sesHeuredebut = $sesHeuredebut;

        return $this;
    }

    /**
     * Get sesHeuredebut
     *
     * @return string 
     */
    public function getSesHeuredebut()
    {
        return $this->sesHeuredebut;
    }

    /**
     * Set sesHeurefin
     *
     * @param string $sesHeurefin
     * @return Session
     */
    public function setSesHeurefin($sesHeurefin)
    {
        $this->sesHeurefin = $sesHeurefin;

        return $this;
    }

    /**
     * Get sesHeurefin
     *
     * @return string 
     */
    public function getSesHeurefin()
    {
        return $this->sesHeurefin;
    }

    /**
     * Set sesDuree
     *
     * @param string $sesDuree
     * @return Session
     */
    public function setSesDuree($sesDuree)
    {
        $this->sesDuree = $sesDuree;

        return $this;
    }

    /**
     * Get sesDuree
     *
     * @return string 
     */
    public function getSesDuree()
    {
        return $this->sesDuree;
    }

    /**
     * Set sesMtype
     *
     * @param \CEOFESABundle\Entity\ModuleT $sesMtype
     * @return Session
     */
    public function setSesMtype(\CEOFESABundle\Entity\ModuleT $sesMtype = null)
    {
        $this->sesMtype = $sesMtype;

        return $this;
    }

    /**
     * Get sesMtype
     *
     * @return \CEOFESABundle\Entity\ModuleT
     */
    public function getSesMtype()
    {
        return $this->sesMtype;
    }

    /**
     * Set sesStype
     *
     * @param \CEOFESABundle\Entity\SessionT $sesStype
     * @return Session
     */
    public function setSesStype(\CEOFESABundle\Entity\SessionT $sesStype = null)
    {
        $this->sesStype = $sesStype;

        return $this;
    }

    /**
     * Get sesStype
     *
     * @return \CEOFESABundle\Entity\SessionT
     */
    public function getSesStype()
    {
        return $this->sesStype;
    }

    /**
     * Set sesFtype
     *
     * @param \CEOFESABundle\Entity\FormationT $sesFtype
     * @return Session
     */
    public function setSesFtype(\CEOFESABundle\Entity\FormationT $sesFtype = null)
    {
        $this->sesFtype = $sesFtype;

        return $this;
    }

    /**
     * Get sesFtype
     *
     * @return \CEOFESABundle\Entity\FormationT
     */
    public function getSesFtype()
    {
        return $this->sesFtype;
    }

    /**
     * Set sesModule
     *
     * @param \CEOFESABundle\Entity\Module $sesModule
     * @return Session
     */
    public function setSesModule(\CEOFESABundle\Entity\Module $sesModule = null)
    {
        $this->sesModule = $sesModule;

        return $this;
    }

    /**
     * Get sesModule
     *
     * @return \CEOFESABundle\Entity\Module 
     */
    public function getSesModule()
    {
        return $this->sesModule;
    }

    /**
     * Set sesStructure
     *
     * @param \CEOFESABundle\Entity\Structure $sesStructure
     * @return Session
     */
    public function setSesStructure(\CEOFESABundle\Entity\Structure $sesStructure = null)
    {
        $this->sesStructure = $sesStructure;

        return $this;
    }

    /**
     * Get sesStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getSesStructure()
    {
        return $this->sesStructure;
    }

    /**
     * Set sesOf
     *
     * @param \CEOFESABundle\Entity\Structure $sesOf
     * @return Session
     */
    public function setSesOf(\CEOFESABundle\Entity\Structure $sesOf = null)
    {
        $this->sesOf = $sesOf;

        return $this;
    }

    /**
     * Get sesOf
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getSesOf()
    {
        return $this->sesOf;
    }
}
