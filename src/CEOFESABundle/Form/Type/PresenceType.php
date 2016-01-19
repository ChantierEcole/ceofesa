<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Repository\DevisRepository;

class PresenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pscDuree','time',array(
                'widget'        => 'text',
                'with_seconds'  => false,
                'attr'          => array('class' => 'form-control')
            ));

        $builder->get('pscDuree')->addModelTransformer(new CallbackTransformer(
                function ($originalTime) {
                    $time = new \DateTime();
                    $time->setTimestamp($originalTime * 3600);
                    $time->modify('-1 hour');
                    return $time;
                },
                function ($submittedTime) {

                    $hour = $submittedTime->format('H');
                    $min = $submittedTime->format('i');

                    return round(floatval($hour + $min / 60), 2);
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CEOFESABundle\Entity\Presence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_presence';
    }
}
