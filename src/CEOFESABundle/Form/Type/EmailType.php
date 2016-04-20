<?php

namespace CEOFESABundle\Form\Type;

use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', 'entity', array(
                'mapped'    => false,
                'property'  => 'nameAndMail',
                'label'     => 'Utilisateurs',
                'class'     => 'CEOFESABundle\Entity\Utilisateurs',
                'attr'      => array('class' => 'js-chosen form-control'),
                'multiple'  => true
            ))
            ->add('sujet', 'text', array(
                'label' => 'Sujet',
                'attr'  => array('class' => 'form-control')
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message',
                'attr'  => array('class' => 'form-control', 'rows' => 10)
            ))
            ->add('envoyer', 'submit', array(
                'attr' => array('class' => 'btn btn-primary')
            ))
            ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'ceofesabundle_email';
    }
}
