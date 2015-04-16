<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class NumSiretStructure extends Constraint
{

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public $message1 = 'Le numéro SIRET ne correspond pas à la structure';
    public $message2 = 'Le numéro SIRET ne semble pas valide';
}