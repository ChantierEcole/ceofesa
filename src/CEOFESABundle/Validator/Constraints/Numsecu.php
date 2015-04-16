<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class Numsecu extends Constraint
{
    public $message = 'Le numéro de sécurité sociale ne semble pas valide';
}