<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ParcoursValidator extends ConstraintValidator
{

    public function __construct($maxHeures){
        $this->max_heures = $maxHeures;
    }

    //Vérification de l'unicité de chaque entrée de parcours ainsi que d'un maximum d'heure pour le devis
    public function validate($value, Constraint $constraint)
    {
        $i = 0;
        $parcours = [];
        $stagiaires = [];
        $totalh = 0;

        foreach ($value->toArray() as $parcour)
        {
            // Récupération des données pour l'unicité
            $data[0] = $parcour->getDprType()->getMtyType();
            $data[1] = $parcour->getDprModule()->getModCode();
            //$data[2] = $parcour->getDprStructure()->getStrNom();
            $data[3] = $parcour->getDprTiers()->getTrsNomPrenom();

            // création d'une chaine de données pour l'entrée
            $result = implode(",", $data);
            
            // vérification de la chaine avec celles entrées précédemment
            // si déjà présente -> message d'erreur
            if(in_array($result, $parcours))
            {
                $this->context->addViolation($constraint->message1);
            }

            // ajout de la chaine dans un tableau pour la comparer avec les suivantes
            $parcours[$i] = $result;

            // Ajout du stagiaire dans un tableau si il n'existe pas déjà
            if(!array_key_exists($data[3],$stagiaires))
            {
                $stagiaires[$data[3]] = 0;
            }

            // Ajout du nombe d'heure au stagiaire (total Heures/Stagiaire)
            $stagiaires[$data[3]] += $parcour->getDprNombreheure();

            $i++;
        }

        foreach ($stagiaires as $stagiaire => $heures) {
            if($heures > $this->max_heures){
                $this->context->addViolation($constraint->message2, array('%number%' => $this->max_heures,'%stagiaire%' => $stagiaire));
            }
        } 
    }
}