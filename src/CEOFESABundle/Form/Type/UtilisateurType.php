<?php 

namespace CEOFESABundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Création du formulaire php
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email','email')
            ->add('siret','number')
            ->add('structure','entity', array(
                'class' => 'CEOFESABundle\Entity\Structure', 
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.strNom', 'ASC')
                    ->where('u.strType = 1');
                }
            ))
            ->add('role','choice', array(
                'choices' => array( 'admin' =>'Administratif (tout)',
                                    'finan' => 'Financier',
                                    'pedag' => 'Pedagogique'),
            ))
            ->add('envoyer','submit', array('attr' => array('class' => 'btn btn-primary')));
    }

    public function getName()
    {
        return 'account_request';
    }
}
