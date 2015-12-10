<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('relOf', 'entity', array(
                'label' => 'OF Principal',
                'class' => 'CEOFESABundle\Entity\Structure',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('str')
                        ->where('str.strType = :type')
                        ->setParameter('type', Structure::TYPE_OF_PRINCIPAL)
                        ->orderBy('str.strNom', 'ASC');
                },
            ))
            ->add('relSoustraitant', 'entity', array(
                'label' => 'Sous-traitant',
                'class' => 'CEOFESABundle\Entity\Structure',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('str')
                        ->where('str.strType = :type')
                        ->setParameter('type', Structure::TYPE_OF_SOUSTRAITANT)
                        ->orderBy('str.strNom', 'ASC');
                },
            ))
            ->add('relDateDebut', 'date', array('label' => 'Date de début de la sous-traitance'))
            ->add('relDateFin', 'date', array('label' => 'Date de fin de la sous-traitance'))
            ->add('enregistrer', 'submit', array(
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
            'data_class' => 'CEOFESABundle\Entity\Relation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_relation';
    }
}
