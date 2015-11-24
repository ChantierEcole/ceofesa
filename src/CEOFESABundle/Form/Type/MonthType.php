<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonthType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module', 'hidden')
            ->add('type', 'hidden')
            ->add('of', 'hidden')
            ->add('date', 'date', array(
                'label'           => 'Pour le mois :',
                'format'          => 'ddMMyyyy',
                'years'           => range(date('Y')-1, date('Y')+5),
                'days'            => array(1),
                'data'            => new \DateTime(),
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'month_type';
    }
}
