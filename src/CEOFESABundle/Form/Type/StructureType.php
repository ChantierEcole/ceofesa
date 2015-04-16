<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StructureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('strNom','text', array('label' => 'Nom'))
            ->add('strAdresse1','text', array('label' => 'Adresse','required' => false))
            ->add('strAdresse2','text', array('label' => false,'required' => false))
            ->add('strCp','number', array('label' => 'Code Postal'))
            ->add('strVille','text', array('label' => 'Ville'))
            ->add('strIncom','number', array('label' => 'Numéro Incom','required' => false))
            ->add('strSiret','number', array('label' => 'SIRET'))
            ->add('strNumof','number', array('label' => 'Numéro OF'))
            ->add('strAdherent','choice', array(
                'choices'  => array(
                    '0' => 'non',
                    '1' => 'oui'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Adhérent'
            ))
            ->add('strTelephone','text', array('label' => 'Téléphone','required' => false))
            ->add('strEmail','email', array('label' => 'Email','required' => false))
            ->add('strEnvoiconvention','choice', array(
                'choices'  => array(
                    '0' => 'non',
                    '1' => 'oui'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Convention envoyée'
            ))
            ->add('strEnvoiavenant','choice', array(
                'choices'  => array(
                    '0' => 'non',
                    '1' => 'oui'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Avenant envoyé'
            ))
            ->add('strRetourconvention','choice', array(
                'choices'  => array(
                    '0' => 'non',
                    '1' => 'oui'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Convention revenue'
            ))
            ->add('strRetouravenant','choice', array(
                'choices'  => array(
                    '0' => 'non',
                    '1' => 'oui'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Avenant revenu'
            ))
            ->add('strDateagrement','date', array('empty_value' => '','required' => false,'label' => 'Date agrement'))
            ->add('strDatefin','date', array('empty_value' => '','required' => false,'label' => 'Date fin'))
            ->add('strDateenvoiconvention','date', array('empty_value' => '','required' => false,'label' => 'Date envoi convention'))
            ->add('strDateretourconvention','date', array('empty_value' => '','required' => false,'label' => 'Date retour convetion'))
            ->add('strDateenvoiavenant','date', array('empty_value' => '','required' => false,'label' => 'Date envoi avenant'))
            ->add('strDateretouravenant','date', array('empty_value' => '','required' => false,'label' => 'Date retour avenant'))
            ->add('strReponsable','text', array('label' => 'Nom Responsable','required' => false))
            ->add('strFonction','text', array('label' => 'Fonction Responsable','required' => false))
            ->add('strRegion','entity',array(
                'class' => 'CEOFESABundle\Entity\Region',
                'property' => 'regNom',
                'multiple' => false,
                'empty_value' => "National",
                'label' => 'Region',
                'required' => false
            ))
            ->add('strType','entity',array(
                'class' => 'CEOFESABundle\Entity\StructureT',
                'property' => 'styType',
                'multiple' => false,
                'label' => 'Type'
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
            'data_class' => 'CEOFESABundle\Entity\Structure'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_structure';
    }
}
