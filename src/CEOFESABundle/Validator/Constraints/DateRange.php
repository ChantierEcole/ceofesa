<?php 

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class DateRange extends Constraint
{

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public $message = 'La date de début doit être strictement inférieure à la date de fin.';
}