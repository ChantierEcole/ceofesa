<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\ModuleRepository;
use CEOFESABundle\Repository\ModuleTRepository;

class SessionType extends AbstractType
{
    protected $idUser;

    public function __construct ($idUser,$module,$modtype,$of)
    {
        $this->idUser = $idUser;
        $this->module = $module;
        $this->modtype = $modtype;
        $this->of = $of;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->idUser;
        $module = $this->module;
        $modtype = $this->modtype;
        $of = $this->of;

        $builder
            ->add('sesDate','date',array(
                'label' => "Date"
            ))
            ->add('sesHeuredebut','text',array(
                'label' => "Heure début"
            ))
            ->add('sesHeurefin','text',array(
                'label' => "Heure fin"
            ))
            ->add('sesDuree','number', array(
                'precision' => 2,
                'label' => "Durée"
            ))
            ->add('sesStructure','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo) use ($id) {
                    return $repo->getUserStructure($id);
                },
                /*'attr' => array('class' => 'hide'),
                'label' => false*/
            ))
            ->add('sesOf','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo) use ($of) {
                    return $repo->getUserStructure($of);
                },
            ))
            ->add('sesMtype','entity', array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'multiple' => false,
                'query_builder' => function(ModuleTRepository $repo) use ($modtype) {
                    return $repo->find($modtype);
                },
            ))
            ->add('sesModule','entity', array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'multiple' => false,
                'query_builder' => function(ModuleRepository $repo) use ($module) {
                    return $repo->find($module);
                },
            ))
            ->add('sesStype')
            ->add('sesFtype')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CEOFESABundle\Entity\Session'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_session';
    }
}
