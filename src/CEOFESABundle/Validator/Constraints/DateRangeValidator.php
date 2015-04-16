<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        if ($protocol->getDevDatedebut() >= $protocol->getDevDatefin()) 
        {
            $this->context->addViolationAt('test',$constraint->message,array(), null);
        }
    }
}