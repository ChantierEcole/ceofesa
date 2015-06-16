<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="tb_Region", uniqueConstraints={@ORM\UniqueConstraint(name="tb_Region_UNIQUE", columns={"reg_Nom"})})
 * @ORM\Entity
 */
class Region
{
    /**
     * @var string
     *
     * @ORM\Column(name="reg_ID", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $regId;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_Nom", type="string", length=45, nullable=false)
     */
    private $regNom;


    /**
     * Set regId
     *
     * @param string $regId
     * @return Region
     */
    public function setRegId($regId)
    {
        $this->regId = $regId;

        return $this;
    }

    /**
     * Get regId
     *
     * @return string 
     */
    public function getRegId()
    {
        return $this->regId;
    }

    /**
     * Set regNom
     *
     * @param string $regNom
     * @return Region
     */
    public function setRegNom($regNom)
    {
        $this->regNom = $regNom;

        return $this;
    }

    /**
     * Get regNom
     *
     * @return string 
     */
    public function getRegNom()
    {
        return $this->regNom;
    }
}
