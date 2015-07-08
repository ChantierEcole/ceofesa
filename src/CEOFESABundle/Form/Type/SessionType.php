<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\ModuleRepository;
use CEOFESABundle\Repository\ModuleTRepository;
use CEOFESABundle\Entity\Session;

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
            ->add('sesHeuredebut','time',array(
                'label' => "Heure début",
                'widget' => 'text',
                'input'  => 'string',
            ))
            ->add('sesHeurefin','time',array(
                'label' => "Heure fin",
                'widget' => 'text',
                'input'  => 'string',
            ))
            ->add('sesDuree','number', array(
                'precision' => 2,
                'label' => "Durée"
            ))
            ->add('sesStructure','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'label' => "Structure",
                'multiple' => false,
                'read_only' => true,
                'query_builder' => function(StructureRepository $repo) use ($id) {
                    return $repo->getUserStructure($id);
                },
                /*'attr' => array('class' => 'hide'),
                'label' => false*/
            ))
            ->add('sesOf','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'label' => "OF",
                'multiple' => false,
                'read_only' => true,
                'query_builder' => function(StructureRepository $repo) use ($of) {
                    return $repo->getUserStructure($of);
                },
            ))
            ->add('sesMtype','entity', array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'label' => "Type de Module",
                'multiple' => false,
                'read_only' => true,
                'query_builder' => function(ModuleTRepository $repo) use ($modtype) {
                    return $repo->getModuleType($modtype);
                },
            ))
            ->add('sesModule','entity', array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'label' => "Module",
                'multiple' => false,
                'read_only' => true,
                'query_builder' => function(ModuleRepository $repo) use ($module) {
                    return $repo->getModule($module);
                },
            ))
            ->add('sesStype','entity', array(
                'class' => 'CEOFESABundle\Entity\SessionT',
                'property' => 'styType',
                'label' => "Type de Session",
                'multiple' => false 
            ))
            ->add('sesFtype','entity', array(
                'class' => 'CEOFESABundle\Entity\FormationT',
                'property' => 'ftyType',
                'label' => "Type de Formation",
                'multiple' => false 
            ))
            ->add('enregistrer','submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $session = $event->getData();

            if($session === null || $session->getSesId() === null)
                return;


            if ($session instanceof Session) {
                $hdebut = $session->getSesHeuredebut();
                $session->setSesHeuredebut($hdebut.':00');
                echo $session->getSesOf();
                echo $session->getSesMtype()->getMtyType();
                $hfin = $session->getSesHeurefin();
                $session->setSesHeurefin($hfin.':00');
            }
        });
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
