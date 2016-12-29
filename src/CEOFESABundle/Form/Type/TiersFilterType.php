<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TiersFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
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
            ->add('filter', 'submit', array('label' => 'Filtrer'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tiers_filter_type';
    }
}
