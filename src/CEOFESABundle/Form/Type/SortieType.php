<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\TiersRepository;

class SortieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cntDatesortie', 'date', array(
                'label' => 'Date de sortie',
            ))
            ->add('cntMotifsortie', 'entity', array(
                'class'    => 'CEOFESABundle\Entity\SortieT',
                'property' => 'srtMotif',
                'label'    => 'Motif de sortie'
            ))
            ->add('enregistrer','submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CEOFESABundle\Entity\DCont'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_sortie';
    }
}
