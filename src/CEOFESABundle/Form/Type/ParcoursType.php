<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Form\Subscriber\ParcoursSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParcoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prcModule', 'entity', array(
                'class'    => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'label'    => 'Module',
            ))
            ->add('prcNombreheure', 'number', array(
                'label' => 'Nb Heures',
            ))
            ->add('prcType', 'entity', array(
                'class'    => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'label'    => 'Type',
            ))
            ->addEventSubscriber(new ParcoursSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('structure'))
            ->setDefaults(array('data_class' => 'CEOFESABundle\Entity\Parcours'))
            ->setAllowedTypes(array('structure' => 'int'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ceofesabundle_parcours';
    }
}
