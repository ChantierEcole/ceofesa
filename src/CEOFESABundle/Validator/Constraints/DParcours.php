<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class DParcours extends Constraint
{
    public function validatedBy()
    {
        return 'max_heures_dparcours';
    }

    public $message1 = "Attention : Il ne peut y avoir le même type de module avec la même structure pour un stagiaire.\n\r Merci de vérifier vos informations.";
    public $message2 = "Attention : Le total de nombre d'heures pour le stagiaire %stagiaire% ne doit pas excéder %number%";
    public $message3 = "Il ne semble pas exister de relation entre OF'ESA, votre Structure et le sous-traitant %sousTraitant%";
    public $message4 = "Le prestataire externe %sousTraitant% ne possède pas d'accord de sous-traitance pour le module M%moduleid%. Merci de vérifier vos informations";

}