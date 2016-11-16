<?php

namespace CEOFESABundle\Export;

use CEOFESABundle\Entity\Parcours;
use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\GeneratorInterface;

class DashboardExporter
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var GeneratorInterface
     */
    private $snappy;

    /**
     * @param EntityManagerInterface $em
     * @param \Twig_Environment      $twig
     * @param GeneratorInterface     $snappy
     */
    public function __construct(EntityManagerInterface $em, \Twig_Environment $twig, GeneratorInterface $snappy)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->snappy = $snappy;
    }

    /**
     * @param Structure $structure
     * @param \DateTime $date
     *
     * @return string
     */
    public function exportPdf(Structure $structure, \DateTime $date)
    {
        $html = $this->twig->render('::Templates\month_recap.html.twig', array(
            'participants' => $this->resolveParticipants($structure, $date),
            'structure'    => $structure,
            'date'         => $date,
        ));

        return $this->snappy->getOutputFromHtml($html, array(
            'orientation' => 'Portrait',
            'page-size'   => 'A4',
        ));
    }

    /**
     * @param Structure $structure
     * @param \DateTime $date
     *
     * @return string
     */
    public function exportCsv(Structure $structure, \DateTime $date)
    {
        $file = fopen('php://memory', 'rw+');

        fputcsv($file, array(
            'Nom',
            'Prénom',
            'DAF',
            'Type',
            'Nombre d\'Heures du mois',
            'Cumul d\'Heures réalisées depuis le début du parcours',
            'Nombre d\'Heures prévues pour le parcours',
            'OF Sous-traitant',
        ));

        $participants = $this->resolveParticipants($structure, $date);

        foreach ($participants as $participant) {
            fputcsv($file, array(
                $participant['nom'],
                $participant['prenom'],
                $participant['dossier'],
                $participant['type'],
                !empty($participant['nombreHeureMois']) ? $participant['nombreHeureMois'] : '0.00',
                !empty($participant['nombreHeureCumulee']) ? $participant['nombreHeureCumulee'] : '0.00',
                !empty($participant['nombreHeureCumulee']) ? $participant['nombreHeureCumulee'] : '0.00',
                $participant['structure'],
            ));
        }

        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);

        return $csv;
    }

    /**
     * @param Structure $structure
     * @param \DateTime $date
     *
     * @return Parcours[]
     */
    private function resolveParticipants(Structure $structure, \DateTime $date)
    {
        return $this->em->getRepository('CEOFESABundle:Parcours')->getParcoursByStructureAndDate(
            $structure->getStrId(),
            $date
        );
    }
}
