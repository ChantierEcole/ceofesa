<?php

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use CEOFESABundle\Repository\StructureRepository;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder
            ->add('structure','entity',array(
                'class' => 'CEOFESABundle\Entity\Structure',
                'multiple' => false,
                'query_builder' => function(StructureRepository $repo){
                    return $repo->getStructures();
                }
            ))
        ;
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'ceofesa_registration';
    }
}