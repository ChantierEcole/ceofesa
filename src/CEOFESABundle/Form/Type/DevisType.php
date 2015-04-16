<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\DevisRepository;

class DevisType extends AbstractType
{

    protected $idStructure;

    public function __construct ($idStructure,$tarif)
    {
        $this->idStructure = $idStructure;
        $this->tarif = $tarif;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->idStructure;
        $tarif = $this->tarif;

        $builder
            ->add('devAnnee','text', array(
                'data' => date("Y"),
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            /*->add('devNumero','text',array(
                    'data' => $numDevis,
                    'attr' => array('class' => 'hide'),
                    'label' => false
                ))*/
            ->add('devDatedevis','datetime',array(
                'data' => new \DateTime(),
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('devDatedebut','date',array(
                'label' => "Date de début"
            ))
            ->add('devDatefin','date',array(
                'label' => "Date de Fin"
            ))
            ->add('devTauxhoraire','text',array(
                'data' => $tarif,
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('devStructure','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo) use ($id) {
                    return $repo->getUserStructure($id);
                },
                'data' => 2,
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('devOf','entity',array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo){
                    return $repo->getOfesa();
                },
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('devParcours','collection', array(
                'type' => new DParcoursType($id),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Stagiaires',
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
            'data_class' => 'CEOFESABundle\Entity\Devis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_devis';
    }
}
