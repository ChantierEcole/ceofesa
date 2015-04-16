<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Params
 *
 * @ORM\Table(name="tb_Params", uniqueConstraints={@ORM\UniqueConstraint(name="unq_params", columns={"par_Structure", "par_Nom"})})
 * @ORM\Entity
 */
class Params
{
    /**
     * @var integer
     *
     * @ORM\Column(name="par_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $parId;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="par_Structure", referencedColumnName="str_ID")
     * })
     */
    private $parStructure;

    /**
     * @var string
     *
     * @ORM\Column(name="par_Nom", type="string", length=45, nullable=true)
     */
    private $parNom;

    /**
     * @var string
     *
     * @ORM\Column(name="par_Valeur", type="string", length=255, nullable=true)
     */
    private $parValeur;



    /**
     * Get parId
     *
     * @return integer 
     */
    public function getParId()
    {
        return $this->parId;
    }

    /**
     * Set parNom
     *
     * @param string $parNom
     * @return Params
     */
    public function setParNom($parNom)
    {
        $this->parNom = $parNom;

        return $this;
    }

    /**
     * Get parNom
     *
     * @return string 
     */
    public function getParNom()
    {
        return $this->parNom;
    }

    /**
     * Set parValeur
     *
     * @param string $parValeur
     * @return Params
     */
    public function setParValeur($parValeur)
    {
        $this->parValeur = $parValeur;

        return $this;
    }

    /**
     * Get parValeur
     *
     * @return string 
     */
    public function getParValeur()
    {
        return $this->parValeur;
    }

    /**
     * Set parStructure
     *
     * @param \CEOFESABundle\Entity\Structure $parStructure
     * @return Params
     */
    public function setParStructure(\CEOFESABundle\Entity\Structure $parStructure = null)
    {
        $this->parStructure = $parStructure;

        return $this;
    }

    /**
     * Get parStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getParStructure()
    {
        return $this->parStructure;
    }
}
