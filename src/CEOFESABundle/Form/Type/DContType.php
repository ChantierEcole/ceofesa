<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\TiersRepository;

class DContType extends AbstractType
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
            ->add('cntTiers', 'entity', array(
                'class' => 'CEOFESABundle\Entity\Tiers',
                'property' => 'trsNomPrenom',
                'label' => 'Stagiaire',
                'multiple' => false,
                'attr' => array('class' => 'stagiaire-widget'),
                'label_attr' => array('class' => 'stagiaire-label'),
                'query_builder' => function(TiersRepository $repo) use ($id) {
                    return $repo->getStructureTiers($id);
                },
            ))
            ->add('cntParcours','collection', array(
                'type' => new ParcoursType($id),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => array('class' => 'parcours-widget'),
                'label' => false,
                'options' => array('label' => false),
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
        return 'ceofesabundle_parcours';
    }
}
