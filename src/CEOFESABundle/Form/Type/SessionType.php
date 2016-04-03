<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Entity\Animation;
use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Entity\Tiers;
use CEOFESABundle\Repository\TiersRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Entity\Session;

class SessionType extends AbstractType
{
    /** @var int */
    protected $idUser;

    /** @var \CEOFESABundle\Repository\StructureRepository */
    protected $structureRepository;

    /** @var \CEOFESABundle\Entity\Structure */
    protected $currentStructure;

    /**
     * @param \CEOFESABundle\Repository\StructureRepository $structureRepository
     * @param int                                           $idUser
     */
    public function __construct (StructureRepository $structureRepository, $idUser)
    {
        $this->idUser = $idUser;
        $this->structureRepository = $structureRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentStructure = $this->getCurrentStructure();

        $builder
            ->add('sesDate', 'date',array(
                'label' => 'Date',
                'years' => [2015, 2016, 2017, 2018, 2019, 2020],
            ))
            ->add('sesHeuredebut', 'time',array(
                'label'  => 'Heure début',
                'widget' => 'text',
                'input'  => 'string',
            ))
            ->add('sesHeurefin', 'time',array(
                'label'  => 'Heure fin',
                'widget' => 'text',
                'input'  => 'string',
            ))
            ->add('sesDuree', 'number', array(
                'precision' => 2,
                'label'     => 'Durée'
            ))
            ->add('sesModule', 'entity', array(
                'class'        => 'CEOFESABundle\Entity\Module',
                'choice_label' => 'modCode',
                'label'        => 'Module',
                'multiple'     => false,
            ))
            ->add('sesMtype', 'entity', array(
                'class'        => 'CEOFESABundle\Entity\ModuleT',
                'choice_label' => 'mtyType',
                'label'        => 'Type de Module',
                'multiple'     => false,
            ))
            ->add('sesOf', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'choice_label'  => 'strNom',
                'label'         => 'OF',
                'multiple'      => false,
                'query_builder' => function (StructureRepository $repo) {
                    return $repo->getOFPrincipal();
                },
            ))
            ->add('sesStype', 'entity', array(
                'class'        => 'CEOFESABundle\Entity\SessionT',
                'choice_label' => 'styType',
                'label'        => 'Type de Session',
                'multiple'     => false
            ))
            ->add('sesFtype', 'entity', array(
                'class'        => 'CEOFESABundle\Entity\FormationT',
                'choice_label' => 'ftyType',
                'label'        => 'Type de Formation',
                'multiple'     => false
            ))
            ->add('formateur', 'entity', array(
                'class'         => Tiers::class,
                'choice_label'  => 'trsNomPrenom',
                'query_builder' => function (TiersRepository $repo) use ($currentStructure) {
                    return $repo->getStructureFormateurs($currentStructure->getStrId());
                },
            ))
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        ;


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {

                $form = $event->getForm();
                $data = $event->getData();

                $type = 'INTRA';
                if ($data !== null && $data->getSesMtype()){
                    $type = $data->getSesMtype()->getMtyType();
                }

                if ($type == 'INTRA') {
                    $form->add('sesOf', 'entity',array(
                        'class'         => 'CEOFESABundle\Entity\Structure',
                        'choice_label'  => 'strNom',
                        'label'         => 'OF',
                        'multiple'      => false,
                        'query_builder' => function (StructureRepository $repo) {
                            return $repo->getIntra();
                        }
                    ));
                } elseif ($type == 'EXTERNE') {
                    $id = $this->idUser;
                    $form->add('sesOf', 'entity',array(
                        'class'         => 'CEOFESABundle\Entity\Structure',
                        'choice_label'  => 'strNom',
                        'label'         => 'OF',
                        'multiple'      => false,
                        'query_builder' => function (StructureRepository $repo) use ($id) {
                            return $repo->getSoustraitants($id);
                        }
                    ));
                }
            }
        );

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $session = $event->getData();

            if ($session === null || $session->getSesId() === null)
                return;


            if ($session instanceof Session) {
                $hdebut = $session->getSesHeuredebut();
                $session->setSesHeuredebut($hdebut.':00');
                $hfin = $session->getSesHeurefin();
                $session->setSesHeurefin($hfin.':00');
            }
        });
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $ofId = $data['sesOf'];
        if ($ofId !== null){
            $form->remove('sesOf');
            $form->add('sesOf', 'entity',array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'choice_label'  => 'strNom',
                'label'         => 'OF',
                'multiple'      => false,
                'query_builder' => function (StructureRepository $repo) use ($ofId) {
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

    /**
     * @return \CEOFESABundle\Entity\Structure|mixed
     */
    protected function getCurrentStructure()
    {
        if ($this->currentStructure === null) {
            $this->currentStructure = $this
                ->structureRepository
                ->getUserStructure($this->idUser)
                ->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();
        }

        return $this->currentStructure;
    }
}
