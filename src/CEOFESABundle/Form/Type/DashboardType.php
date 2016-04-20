<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Repository\StructureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DashboardType extends AbstractType
{
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
        return 'dashboard_type';
    }
}
