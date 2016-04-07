<?php

namespace CEOFESABundle\Validator\Constraints;

use CEOFESABundle\Entity\Animation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Matthieu Sansen <matthieu.sansen@outlook.com>
 */
class SessionValidator extends ConstraintValidator
{
    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param \CEOFESABundle\Entity\Session           $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        // Check if formateur is available
        if ($value->getFormateur() && $value->getSesDate() && $value->getSesHeuredebut() && $value->getSesHeurefin()) {
            $schedule = $this
                ->em
                ->getRepository('CEOFESABundle:Animation')
                ->checkFormateurAvailability(
                    $value->getFormateur()->getTrsId(),
                    $value->getSesDate(),
                    $value->getSesHeuredebut(),
                    $value->getSesHeurefin(),
                    $value->getSesId()
                );

            if (!empty($schedule)) {
                $sessions = array();

                /** @var \CEOFESABundle\Entity\Animation $animation */
                foreach ($schedule as $animation) {
                    $sessions[] = $animation->getAniSession()->getSesId();
                }

                $this->context->addViolationAt(
                    'formateur',
                    $constraint->message,
                    array('%sessions%' => implode(', ', $sessions)),
                    null,
                    count($sessions)
                );
            }

        }

    }
}
