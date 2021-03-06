<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DashboardType extends AbstractType
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = date('Y');

        $builder
            ->add('start', 'date', array(
                'label'  => 'Date de début:',
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years'  => range($year - 5, $year + 5),
                'data'   => new \DateTime(date('Y-m-01 00:00:00')),
            ))
            ->add('end', 'date', array(
                'label'  => 'Date de fin:',
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years'  => range($year - 5, $year + 5),
                'data'   => new \DateTime(date('Y-m-t 23:59:59')),
            ))
            ->add('save', 'submit', array('label' => 'Afficher'))
            ->add('print', 'submit', array('label' => 'Imprimer'));

        if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $builder->add('export', 'submit', array('label' => 'Exporter'));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dashboard_type';
    }
}
