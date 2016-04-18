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
            ->add('relEnvoiconvention', 'checkbox', array(
                'label'    => 'Convention envoyée',
                'required' => false
            ))
            ->add('relRetourconvention', 'checkbox', array(
                'label'    => 'Convention revenue',
                'required' => false,
            ))
            ->add('relEnvoiavenant', 'checkbox', array(
                'label'    => 'Avenant envoyé',
                'required' => false,
            ))
            ->add('relRetouravenant', 'checkbox', array(
                'label'    => 'Avenant revenu',
                'required' => false,
            ))
            ->add('relDateenvoiconvention', 'date', array(
                'label'       => 'Date d\'envoi de la convention',
                'placeholder' => "",
                'required'    => false,
            ))
            ->add('relDateretourconvention', 'date', array(
                'label'       => 'Date de retour de la convention',
                'placeholder' => "",
                'required'    => false,
            ))
            ->add('relDateenvoiavenant', 'date', array(
                'label'       => 'Date d\'envoi de l\'avenant',
                'placeholder' => "",
                'required'    => false,
            ))
            ->add('relDateretouravenant', 'date', array(
                'label'       => 'Date de retour de l\'avenant',
                'placeholder' => "",
                'required'    => false,
            ))
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
