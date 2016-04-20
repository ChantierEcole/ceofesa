<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\DevisRepository;

class DafType extends AbstractType
{
    protected $idStructure;

    public function __construct ($idStructure)
    {
        $this->idStructure = $idStructure;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->idStructure;

        $builder
            ->add('dafDossier','text',array(
                'label' => "Numéro de dossier"
            ))
            ->add('dafDatedebut','date',array(
                'label' => "Date de début"
            ))
            ->add('dafDatefin','date',array(
                'label' => "Date de Fin"
            ))
            ->add('dafTauxhoraire','text',array(
                'label' => "Taux horaire (€)"
            ))
            ->add('dafDcont','collection', array(
                'type' => new DContType($id),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'attr' => array('class' => 'collection-group')
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
            'data_class' => 'CEOFESABundle\Entity\DAF'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_daf';
    }
}
