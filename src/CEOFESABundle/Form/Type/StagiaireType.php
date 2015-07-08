<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\TiersTRepository;
use CEOFESABundle\Repository\StructureRepository;

class StagiaireType extends AbstractType
{
    protected $idUser;

    public function __construct ($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->idUser;
        $builder
            ->add('trsNom','text', array('label' => 'Nom'))
            ->add('trsPrenom','text', array('label' => 'Prénom'))
            ->add('trsAdresse1','text', array('label' => 'Adresse'))
            ->add('trsAdresse2','text', array('label' => false,'required' => false))
            ->add('trsCp', 'text', array('label' => 'Code Postal'))
            ->add('trsVille', 'text', array('label' => 'Ville'))
            ->add('trsTel1', 'text', array('label' => 'Téléphone 1','required' => false))
            ->add('trsTel2', 'text', array('label' => 'Téléphone 2','required' => false))
            ->add('trsPortable','text', array('label' => 'Tel. Portable','required' => false))
            ->add('trsEmail', 'email', array('label' => 'Email','required' => false))
            ->add('trsFonction','text', array('label' => 'Fonction', 'data' => 'Salarié Polyvalent','attr' => array('class' => 'hide'),'label' => false))
            ->add('trsDatenaissance','birthday', array('label' => 'Date de Naissance'))
            ->add('trsLieunaissance','text', array('label' => 'Lieu de Naissance','required' => false))
            ->add('trsNumsecu','text', array('label' => 'Numéro de sécurité sociale','required' => false))
            ->add('trsStructure','entity', array(
                                                'class' => 'CEOFESABundle\Entity\Structure',
                                                'property' => 'strNom',
                                                'multiple' => false,
                                                'query_builder' => function(StructureRepository $repo) use($id) {
                                                    return $repo->getUserStructure($id);
                                                },
                                                'attr' => array('class' => 'hide'),
                                                'label' => false
                                            ))
            ->add('trsType', 'entity', array(
                                                'class' => 'CEOFESABundle\Entity\TiersT',
                                                'property' => 'ttyType',
                                                'multiple' => false,
                                                'query_builder' => function(TiersTRepository $repo) {
                                                    return $repo->getStagiaireTypeBuilder();
                                                },
                                                'attr' => array('class' => 'hide'),
                                                'label' => false
                                            ))
            ->add('trsCivilite','entity', array(
                                                'class' => 'CEOFESABundle\Entity\CiviliteT',
                                                'property' => 'ctyType',
                                                'multiple' => false,
                                                'label' => 'Civilite'
                                            ))
            ->add('enregistrer','submit', array(
                'attr' => array('class' => 'btn-primary')
                )
            )
        ;

        /* Mise en forme du numéro de sécu pour s'assurer qu'il y a des espaces aux bons endroits. */
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function(FormEvent $event) {
                $data = $event->getForm()->getData();
                $num = $data->getTrsNumsecu();
                $num = str_replace(' ', '', $num); // Au cas ou il y aurait déjà des espaces
                list($sexe, $annee, $mois, $departement, $insee, $ordre, $cle) = sscanf($num, '%1s%2s%2s%2s%3s%3s%2s');
                $num = $sexe.' '.$annee.' '.$mois.' '.$departement.' '.$insee.' '.$ordre.' '.$cle;
                $data->setTrsNumsecu($num);
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
            'data_class' => 'CEOFESABundle\Entity\Tiers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_stagiaire';
    }
}
