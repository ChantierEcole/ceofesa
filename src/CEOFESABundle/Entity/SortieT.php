<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SortieT
 *
 * @ORM\Table(name="tb_SortieT", uniqueConstraints={@ORM\UniqueConstraint(name="unq_sortiet", columns={"srt_Motif"})})
 * @ORM\Entity
 */
class SortieT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="srt_ID", type="integer", nullable=false)
     * @ORM\Id
     */
    private $srtId;

    /**
     * @var string
     *
     * @ORM\Column(name="srt_Motif", type="string", length=60, nullable=false)
     */
    private $srtMotif;


    /**
     * Set srtId
     *
     * @param integer $srtId
     * @return SortieT
     */
    public function setSrtId($srtId)
    {
        $this->srtId = $srtId;

        return $this;
    }

    /**
     * Get srtId
     *
     * @return integer
     */
    public function getSrtId()
    {
        return $this->srtId;
    }

    /**
     * Set srtMotif
     *
     * @param string $srtMotif
     * @return SortieT
     */
    public function setSrtMotif($srtMotif)
    {
        $this->srtMotif = $srtMotif;

        return $this;
    }

    /**
     * Get srtMotif
     *
     * @return string 
     */
    public function getSrtMotif()
    {
        return $this->srtMotif;
    }
}
