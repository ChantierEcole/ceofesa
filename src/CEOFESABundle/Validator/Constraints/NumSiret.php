<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class NumSiret extends Constraint
{
    public $message = "Le numéro de SIRET ne semble pas valide";
}