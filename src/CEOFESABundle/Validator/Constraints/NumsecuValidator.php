<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NumsecuValidator extends ConstraintValidator
{
    /* Vérification du numéro de sécurité sociale grâce à sa clé */
    /*public function validate($value, Constraint $constraint)
    {
        $num = str_replace(' ', '', $value);
        list($secu, $cle) = sscanf($num, '%13d%2d');
        if(($secu+$cle)%97 != 0) {
            $this->context->addViolation($constraint->message);
        }
    }*/

    /* Vérifie que le numéro de sécurité social est null ou compris entre 13 et 15 chiffres */
    public function validate($value, Constraint $constraint)
    {
    	$numString = str_replace(' ', '', $value);
    	if ($numString != null || $numString != '') {
    		echo ('value :'.$numString.'?');
			$stringLength = strlen($numString);
			if ($stringLength < 13 || $stringLength > 15){
				$this->context->addViolation($constraint->message2);
			}
		}
	}
}