<?php

namespace CEOFESABundle\Form\Subscriber;

use CEOFESABundle\Repository\StructureRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ParcoursSubscriber implements EventSubscriberInterface
{
    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $type = $data !== null ? $data->getPrcType()->getMtyType() : 'INTRA';

        if ($type === 'INTRA') {
            $form->add('prcStructure', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'property'      => 'strNom',
                'label'         => 'OF',
                'multiple'      => false,
                'query_builder' => function(StructureRepository $repository) {
                    return $repository->getIntra();
                },
            ));
        } elseif ($type === 'EXTERNE') {
            $form->add('prcStructure', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'property'      => 'strNom',
                'label'         => 'OF',
                'multiple'      => false,
                'query_builder' => function(StructureRepository $repository) use ($form) {
                    return $repository->getSoustraitants($form->getConfig()->getOption('structure'));
                }
            ));
        }
    }

    /**
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!isset($data['prcStructure']) || $data['prcStructure'] === null) {
            return;
        }

        $form = $event->getForm();
        $ofId = $data['prcStructure'];

        $form
            ->remove('prcStructure')
            ->add('prcStructure', 'entity', array(
                'class'         => 'CEOFESABundle\Entity\Structure',
                'property'      => 'strNom',
                'label'         => 'OF',
                'multiple'      => false,
                'query_builder' => function(StructureRepository $repo) use ($ofId) {
                    return $repo->getSoustraitant($ofId);
                }
            ));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        );
    }
}
