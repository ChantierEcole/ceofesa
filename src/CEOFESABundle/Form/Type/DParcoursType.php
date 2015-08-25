<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\TiersRepository;

class DParcoursType extends AbstractType
{
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
            ->add('dprNumero','text',array(
                'data' => '0',
                'attr' => array('class' => 'hide'),
                'label' => false
            ))
            ->add('dprTiers','entity',array(
                'class' => 'CEOFESABundle\Entity\Tiers',
                'property' => 'trsNomPrenom',
                'label' => 'Stagiaire',
                'multiple' => false,
                'query_builder' => function(TiersRepository $repo) use ($id) {
                    return $repo->getStructureTiers($id);
                },
            ))
            ->add('dprModule','entity',array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'label' => 'Module'
            ))
            ->add('dprNombreheure','number', array(
                'label' => "Nb Heures",
            ))
            ->add('dprType','entity',array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'label' => 'Type'
            ))
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {

                $form = $event->getForm();

                $data = $event->getData();

                if($data != null){
                    $type = $data->getDprType()->getMtyType();
                } else {
                    $type = "INTRA";
                }

                if($type == "INTRA") {
                    $form->add('dprStructure','entity',array(
                        'class' => 'CEOFESABundle\Entity\Structure',
                        'property' => 'strNom',
                        'label' => 'OF',
                        'multiple' => false,
                        'query_builder' => function(StructureRepository $repo){
                            return $repo->getIntra();
                        }
                    ));
                } elseif($type == "EXTERNE") {
                    $id = $this->idStructure;
                    $form->add('dprStructure','entity',array(
                        'class' => 'CEOFESABundle\Entity\Structure',
                        'property' => 'strNom',
                        'label' => 'OF',
                        'multiple' => false,
                        'query_builder' => function(StructureRepository $repo) use ($id){
                            return $repo->getSoustraitants($id);
                        }
                    ));
                }
            }
        );

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    public function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $ofId = $data['dprStructure'];
        if($ofId != null){ 
            $form->remove('dprStructure');
            $form->add('dprStructure','entity',array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'property' => 'strNom',
                'label' => 'OF',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo) use($ofId) {
                    return $repo->getSoustraitant($ofId);
                }
            ));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CEOFESABundle\Entity\DParcours'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_dparcours';
    }
}
