<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class Numsecu extends Constraint
{
    public $message = 'Le numéro de sécurité sociale ne semble pas valide';
    public $message2 = 'Le numéro de sécurité sociale doit comporter entre 13 et 15 chiffres';
}