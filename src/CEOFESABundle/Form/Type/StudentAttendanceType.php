<?php

namespace CEOFESABundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentAttendanceType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = date('Y');
        $id = isset($options['structure']) ? $options['structure'] : false;

        $builder
            ->add('stagiaire', 'entity', [
                'class' => 'CEOFESABundle\Entity\Tiers',
                'property' => 'trsNomPrenom',
                'query_builder' => function(EntityRepository $er) use ($id) {
                    return ($id) ? $er->getStructureStagiaires($id) : $er->getStagiaires();
                },
            ]);
        $builder->add('start', 'date', [
                'label'  => 'du mois:',
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years'  => range($year - 10, $year + 10),
                'data'   => new \DateTime(date('Y-m-01 00:00:00')),
            ])
            ->add('end', 'date', [
                'label'  => 'au mois:',
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years'  => range($year - 10, $year + 10),
                'data'   => new \DateTime(date('Y-m-t 23:59:59')),
            ])
            ->add('print', 'submit', ['label' => 'Imprimer']);
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
     * @return string
     */
    public function getName()
    {
        return 'student_attendance_type';
    }
}
