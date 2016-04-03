<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @author Matthieu Sansen <matthieu.sansen@outlook.com>
 */
class Session extends Constraint
{
    public $message = 'Ce formateur est déjà occupé sur la session suivante: %sessions%|Ce formateur est déjà occupé sur les sessions suivante: %sessions%';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'ceofesa.validator.class_session';
    }
}
