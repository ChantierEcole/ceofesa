<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @author Florent Rosso <florent@widop.com>
 */
class Presence extends Constraint
{
    public $message = "La durée doit être inferieure ou égale à celle de la session";

    /**
     *  {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     *  {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'ceofesa.validator.class_presence';
    }
}
