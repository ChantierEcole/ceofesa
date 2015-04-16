<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NumSiretStructureValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        // vérification du numéro SIRET
        $siret = $protocol->getSiret();

        // Si le SIRET ne correspond pas à celui de la structure --> message d'erreur
        if ($protocol->getStructure()->getStrSiret() != $siret) 
        {
            $this->context->addViolationAt('correspondance',$constraint->message1,array(), null);
        }

        // vérification de la validité du numéro (cf formule de Luhn)
        $total = 0;
        $len = strlen($siret);
        // Pour chaque chiffre du SIRET ...
        for ($i = 0; $i <= $len; $i++) {
            $chiffre = substr($siret,$i,1);
            // Si il est pair : on le multiplie par 2
            if($i % 2 == 0) {
                // puis on l'aditionne avec les précédents
                $total += 2 * $chiffre;
                // Si le chiffre est plus grand que 9 on soustrait 9 au total
                if((2 * $chiffre) >= 10){
                    $total -= 9;
                }
            // Sinon on l'additionne simplement avec les précédents
            }else{
              $total += $chiffre;  
            }
        }
        // Si le total n'est pas un multiple de 10, le SIRET n'est pas valide --> message d'erreur
        if($total % 10 != 0){
            $this->context->addViolationAt('validite',$constraint->message2,array(), null);
        }
    }
}