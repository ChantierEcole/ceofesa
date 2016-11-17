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
        $builder
            ->add('date', 'date', array(
                'label'           => 'Pour le mois :',
                'format'          => 'ddMMyyyy',
                'years'           => range(date('Y')-5, date('Y')+5),
                'days'            => array(1),
                'data'            => new \DateTime(),
            ))
            ->add('save', 'submit', array('label' => 'Afficher'))
            ->add('print', 'submit', array('label' => 'Imprimer'));

        if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $builder->add('export', 'submit', array('label' => 'Éxporter'));
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
