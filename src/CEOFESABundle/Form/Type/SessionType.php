<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sesDate','date',array(
                'label' => "Date"
            ))
            ->add('sesHeuredebut','text',array(
                'label' => "Heure début"
            ))
            ->add('sesHeurefin','text',array(
                'label' => "Heure fin"
            ))
            ->add('sesDuree','number', array(
                'precision' => 2,
                'label' => "Durée"
            ))
            ->add('sesStructure','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo) use ($id) {
                    return $repo->getUserStructure($id);
                },
                /*'attr' => array('class' => 'hide'),
                'label' => false*/
            ))
            ->add('sesOf')
            ->add('sesMtype')
            ->add('sesModule')
            ->add('sesStype')
            ->add('sesFtype')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CEOFESABundle\Entity\Session'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_session';
    }
}
