<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tb_StuckApcMonth")
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\StuckApcMonthRepository")
 */
class StuckApcMonth
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CEOFESABundle\Entity\DAF", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, referencedColumnName="daf_ID")
     */
    private $idDAF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(
     *     name="date_stuck",
     *     type="date",
     *     nullable=false
     * )
     */
    private $dateStuck;

    /**
     * @return \DateTime
     */
    public function getDateStuck()
    {
        return $this->dateStuck;
    }

    /**
     * @param \DateTime $dateStuck
     */
    public function setDateStuck($dateStuck)
    {
        $this->dateStuck = $dateStuck;
    }

    /**
     * @return DAF
     */
    public function getIdDAF()
    {
        return $this->idDAF;
    }

    /**
     * @param $idDAF
     *
     * @return $this
     */
    public function setIdDAF($idDAF)
    {
        $this->idDAF = $idDAF;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
