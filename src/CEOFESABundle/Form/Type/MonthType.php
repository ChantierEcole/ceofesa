<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Entity\Opca;
use CEOFESABundle\Repository\StructureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonthType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opca = Opca::getChoices();
        $id = $options['structure'];

        $builder
            ->add('module', 'entity', array(
                'class'    => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'multiple' => false,
            ))
            ->add('type', 'entity', array(
                'class'    => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'multiple' => false,
            ))
            ->add('of', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'required'      => true,
                'multiple'      => false,
                'query_builder' => function(StructureRepository $repo) use ($id) {
                    return $repo->getOFPrincipalAndSousTraitants($id);
                }
            ))
            ->add('opca', 'choice', array(
                'required' => true,
                'choices'  => array_combine($opca, $opca),
            ))
            ->add('date', 'date', array(
                'label'  => 'Pour le mois :',
                'format' => 'ddMMyyyy',
                'years'  => range(date('Y')-5, date('Y')+5),
                'days'   => array(1),
                'data'   => new \DateTime(),
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('structure'))
            ->setAllowedTypes(array('structure' => array('int', 'string')));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'month_type';
    }
}
