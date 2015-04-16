<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureTRepository;

class SoustraitantType extends AbstractType
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
            ->add('strSiret','number', array('label' => 'SIRET'))
            ->add('strTelephone','text', array('label' => 'Téléphone','required' => false))
            ->add('strEmail','email', array('label' => 'Email','required' => false))
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
                'query_builder' => function(StructureTRepository $repo) {
                    return $repo->getSoustraitantTypeBuilder();
                },
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('enregistrer','submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        ;

        /* On retire les espaces du numéro SIRET */
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function(FormEvent $event) {
                $data = $event->getForm()->getData();
                $siret = $data->getStrSiret();
                $siret = str_replace(' ', '', $siret);
                $data->setStrSiret($siret);
                $event->setData($data);
            }
        );
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
        return 'ceofesabundle_soustraitant';
    }
}
