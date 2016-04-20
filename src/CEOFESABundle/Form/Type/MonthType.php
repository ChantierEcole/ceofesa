<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Repository\StructureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('module','entity',array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'multiple' => false,
            ))
            ->add('type','entity',array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'multiple' => false,
            ))
            ->add('of','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'required'  => true,
                'multiple'  => false,
                'query_builder' => function(StructureRepository $repo) {
                    return $repo->getOFPrincipal();
                }
            ))
            ->add('date', 'date', array(
                'label'           => 'Pour le mois :',
                'format'          => 'ddMMyyyy',
                'years'           => range(date('Y')-5, date('Y')+5),
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
