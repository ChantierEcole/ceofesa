<?php 

namespace CEOFESABundle\Form\Domain;

use Symfony\Component\Validator\Constraints as Assert;
use CEOFESABundle\Validator\Constraints as CeofesaAssert;
/**
 * @CeofesaAssert\NumSiretStructure
 */
class utilisateur
{
    /**
    * @Assert\NotBlank
    * @Assert\Length(min=2, max=30)
    */
    public $nom;
    /**
    * @Assert\NotBlank
    * @Assert\Length(min=2, max=30)
    */
    public $prenom;
    /**
    * @Assert\NotBlank
    * @Assert\Email
    */
    public $email;
    /**
    * @Assert\NotBlank
    * @Assert\Length(min=14, max=14)
    */
    public $siret;
    /**
    * @Assert\NotBlank
    */
    public $structure;
    /**
    * @Assert\NotBlank
    */
    public $role;

    /**
     * Get siret
     *
     * @return integer 
     */
    public function getSiret()
    {
        return $this->siret;
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