<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class StuckApcMonthType
 *
 * @package CEOFESABundle\Form\Type
 */
class StuckApcMonthType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = date('Y');

        $builder
        ->add('dateStuck', 'date', [
            'label'  => 'Bloquer le mois:',
            'widget' => 'choice',
            'format' => 'ddMMyyyy',
            'years'  => range($year - 10, $year + 10),
            'data'   => new \DateTime(date('Y-m-01 00:00:00')),
        ])
        ->add('save', 'submit', ['label' => 'Sauvegarder']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CEOFESABundle\Entity\StuckApcMonth'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'stuck_apc_month_type';
    }
}
