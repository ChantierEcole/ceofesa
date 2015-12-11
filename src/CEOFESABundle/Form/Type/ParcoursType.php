<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\TiersRepository;

class ParcoursType extends AbstractType
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
        $builder
            ->add('prcModule','entity',array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'label' => 'Module'
            ))
            ->add('prcNombreheure','number', array(
                'label' => "Nb Heures",
            ))
            ->add('prcType','entity',array(
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
                    $type = $data->getPrcType()->getMtyType();
                } else {
                    $type = "INTRA";
                }

                if($type == "INTRA") {
                    $form->add('prcStructure','entity',array(
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
                    $form->add('prcStructure','entity',array(
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

        $ofId = $data['prcStructure'];
        if($ofId != null){
            $form->remove('prcStructure');
            $form->add('prcStructure','entity',array(
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
            'data_class' => 'CEOFESABundle\Entity\Parcours'
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
