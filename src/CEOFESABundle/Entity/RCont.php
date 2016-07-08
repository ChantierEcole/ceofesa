<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RCont
 *
 * @ORM\Table(name="tb_RCont", uniqueConstraints={@ORM\UniqueConstraint(name="unq_rcont", columns={"rcn_Relation", "rnc_Module"})}, indexes={@ORM\Index(name="FKEY18_idx", columns={"rcn_Relation"}), @ORM\Index(name="FKEY19_idx", columns={"rnc_Module"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\RContRepository")
 */
class RCont
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rcn_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rcnId;

    /**
     * @var Relation
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Relation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rcn_Relation", referencedColumnName="rel_ID", nullable=false)
     * })
     */
    private $rcnRelation;

    /**
     * @var Module
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rnc_Module", referencedColumnName="mod_ID", nullable=false)
     * })
     */
    private $rncModule;



    /**
     * Get rcnId
     *
     * @return integer 
     */
    public function getRcnId()
    {
        return $this->rcnId;
    }

    /**
     * Set rcnRelation
     *
     * @param \CEOFESABundle\Entity\Relation $rcnRelation
     * @return RCont
     */
    public function setRcnRelation(\CEOFESABundle\Entity\Relation $rcnRelation = null)
    {
        $this->rcnRelation = $rcnRelation;

        return $this;
    }

    /**
     * Get rcnRelation
     *
     * @return \CEOFESABundle\Entity\Relation 
     */
    public function getRcnRelation()
    {
        return $this->rcnRelation;
    }

    /**
     * Set rncModule
     *
     * @param \CEOFESABundle\Entity\Module $rncModule
     * @return RCont
     */
    public function setRncModule(\CEOFESABundle\Entity\Module $rncModule = null)
    {
        $this->rncModule = $rncModule;

        return $this;
    }

    /**
     * Get rncModule
     *
     * @return \CEOFESABundle\Entity\Module 
     */
    public function getRncModule()
    {
        return $this->rncModule;
    }
}
