<?php

namespace CEOFESABundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tb_Utilisateurs")
 */
class Utilisateurs extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @var \Structure
    *
    * @ORM\ManyToOne(targetEntity="Structure")
    * @ORM\JoinColumn(name="structure", referencedColumnName="str_ID",nullable=false)
    *
    */
    protected $structure;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_USER');
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set structure
     *
     * @param integer $structure
     * @return Utilisateurs
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getStructure()
    {
        return $this->structure;
    }
}
