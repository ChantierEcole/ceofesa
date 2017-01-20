<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\TiersRepository;

class DContType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['structure'];

        $builder
            ->add('cntTiers', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Tiers',
                'property'      => 'trsNomPrenom',
                'label'         => 'Stagiaire',
                'multiple'      => false,
                'attr'          => array('class' => 'stagiaire-widget'),
                'label_attr'    => array('class' => 'stagiaire-label'),
                'query_builder' => function(TiersRepository $repository) use ($id) {
                    return $repository->getStructureTiers($id);
                },
            ))
            ->add('cntParcours', 'collection', array(
                'type'         => new ParcoursType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr'         => array('class' => 'parcours-widget'),
                'label'        => false,
                'options'      => array('structure' => $id, 'label' => false),
                'prototype_name' => '__name_parcours__'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('structure'))
            ->setDefaults(array('data_class' => 'CEOFESABundle\Entity\DCont'))
            ->setAllowedTypes(array('structure' => array('int', 'string')));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ceofesabundle_parcours';
    }
}
