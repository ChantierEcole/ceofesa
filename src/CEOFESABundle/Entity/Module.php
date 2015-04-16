<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="tb_Module", indexes={@ORM\Index(name="mod_Code", columns={"mod_Code"})})
 * @ORM\Entity
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="mod_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $modId;

    /**
     * @var string
     *
     * @ORM\Column(name="mod_Code", type="string", length=5, nullable=true)
     */
    private $modCode;

    /**
     * @var string
     *
     * @ORM\Column(name="mod_Intitule", type="string", length=50, nullable=true)
     */
    private $modIntitule;

    /**
     * @var string
     *
     * @ORM\Column(name="mod_Intitule_Long", type="string", length=255, nullable=true)
     */
    private $modIntituleLong;



    /**
     * Get modId
     *
     * @return integer 
     */
    public function getModId()
    {
        return $this->modId;
    }

    /**
     * Set modCode
     *
     * @param string $modCode
     * @return Module
     */
    public function setModCode($modCode)
    {
        $this->modCode = $modCode;

        return $this;
    }

    /**
     * Get modCode
     *
     * @return string 
     */
    public function getModCode()
    {
        return $this->modCode;
    }

    /**
     * Set modIntitule
     *
     * @param string $modIntitule
     * @return Module
     */
    public function setModIntitule($modIntitule)
    {
        $this->modIntitule = $modIntitule;

        return $this;
    }

    /**
     * Get modIntitule
     *
     * @return string 
     */
    public function getModIntitule()
    {
        return $this->modIntitule;
    }

    /**
     * Set modIntituleLong
     *
     * @param string $modIntituleLong
     * @return Module
     */
    public function setModIntituleLong($modIntituleLong)
    {
        $this->modIntituleLong = $modIntituleLong;

        return $this;
    }

    /**
     * Get modIntituleLong
     *
     * @return string 
     */
    public function getModIntituleLong()
    {
        return $this->modIntituleLong;
    }
}
