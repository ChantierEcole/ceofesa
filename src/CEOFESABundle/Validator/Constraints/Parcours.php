<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class Parcours extends Constraint
{
    public function validatedBy()
    {
        return 'max_heures';
    }

    public $message1 = "Attention : Il ne peut y avoir le même type de module avec la même structure pour un stagiaire.\n\r Merci de vérifier vos informations.";
    public $message2 = "Attention : Le total de nombre d'heures pour le stagiaire %stagiaire% ne doit pas excéder %number%";
}