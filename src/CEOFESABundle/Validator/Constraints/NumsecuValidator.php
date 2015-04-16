<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NumsecuValidator extends ConstraintValidator
{
    /* Vérification du numéro de sécurité sociale grâce à sa clé */
    public function validate($value, Constraint $constraint)
    {
        $num = str_replace(' ', '', $value);
        list($secu, $cle) = sscanf($num, '%13d%2d');
        if(($secu+$cle)%97 != 0) {
            $this->context->addViolation($constraint->message);
        }
    }
}