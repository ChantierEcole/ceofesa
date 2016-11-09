<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DafType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['structure'];

        $builder
            ->add('dafDossier', 'text', array('label' => 'Numéro de dossier'))
            ->add('dafDatedebut', 'date', array('label' => 'Date de début'))
            ->add('dafDatefin', 'date', array('label' => 'Date de Fin'))
            ->add('dafTauxhoraire', 'text', array('label' => 'Taux horaire (€)'))
            ->add('dafDcont', 'collection', array(
                'type'         => new DContType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'        => false,
                'attr'         => array('class' => 'collection-group'),
                'options'      => array('structure' => $id),
            ))
            ->add('enregistrer', 'submit', array('attr' => array('class' => 'btn-primary')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('structure'))
            ->setDefaults(array('data_class' => 'CEOFESABundle\Entity\DAF'))
            ->setAllowedTypes(array('structure' => array('int', 'string')));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ceofesabundle_daf';
    }
}
