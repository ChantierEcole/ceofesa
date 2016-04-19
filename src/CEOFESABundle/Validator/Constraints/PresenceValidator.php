<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 *
 * @author Florent Rosso <florent@widop.com>
 */
class PresenceValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value->getPscSession()->getSesDuree() < $value->getPscDuree()) {
            $this->context->addViolationAt('pscDuree', $constraint->message);
        }
    }
}
