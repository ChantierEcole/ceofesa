<?php

namespace CEOFESABundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

class ParcoursValidator extends ConstraintValidator
{

    public function __construct($maxHeures,EntityManager $entityManager){
        $this->max_heures = $maxHeures;
        $this->em = $entityManager;
    }

    //Vérification de l'unicité de chaque entrée de parcours, d'un maximum d'heures pour le devis et de la concordance Module/Sous-traitant (RCont)
    public function validate($value, Constraint $constraint)
    {
        $i = 0;
        $parcours = [];
        $stagiaires = [];
        $totalh = 0;

        foreach ($value->toArray() as $parcour)
        {
            // Récupération des données pour l'unicité
            $data[0] = $parcour->getPrcType()->getMtyType();
            $data[1] = $parcour->getPrcModule()->getModCode();
            $data[2] = $parcour->getPrcTiers()->getTrsNomPrenom();
            $data[3] = $parcour->getPrcStructure()->getStrId();

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
            $i++;

            // Ajout du stagiaire dans un tableau si il n'existe pas déjà
            if(!array_key_exists($data[2],$stagiaires))
            {
                $stagiaires[$data[2]] = 0;
            }

            // Ajout du nombe d'heure au stagiaire (total Heures/Stagiaire)
            $stagiaires[$data[2]] += $parcour->getPrcNombreheure();

            ///

            if($data[0] == "EXTERNE")
            {
                $idModule = $parcour->getPrcModule()->getModId();
                $sousTraitant = $parcour->getPrcStructure()->getStrNom();

                $idStructure = $parcour->getPrcDevis()->getDevStructure();
                $idOF = $parcour->getPrcDevis()->getDevOf();
                $idSousTraitant = $parcour->getPrcStructure()->getStrId();

                //On vérifie si la relation OF/Structure/Sous-traitant existe bien et on prend son ID
                $relation = $this->em->getRepository('CEOFESABundle:Relation')->getRelation($idStructure,$idSousTraitant,$idOF)->getQuery()->getOneOrNullResult();
                if($relation){
                    $idRelation = $relation->getRelId();
                } else {
                    $this->context->addViolation($constraint->message3, array('%sousTraitant%' => $sousTraitant));
                }

                //On vérifie si le sous-traitant s'occupe bien du module choisi
                $modules = $this->em->getRepository('CEOFESABundle:RCont')->getModules($idRelation)->getQuery()->getResult();

                if(!$modules){
                    $this->context->addViolation($constraint->message4, array('%moduleid%' => 'pas de module', '%sousTraitant%' => $sousTraitant));
                } else {
                    $valid = 'false';
                    foreach ($modules as $module) {
                        $RelationModId = $module->getRncModule()->getModId();
                        if($RelationModId == $idModule){
                            $valid = 'true';
                        }
                    }
                    if($valid == 'false'){
                        $this->context->addViolation($constraint->message4, array('%moduleid%' => $idModule, '%sousTraitant%' => $sousTraitant));
                    }
                }
            }
            
        }

        foreach ($stagiaires as $stagiaire => $heures) {
            if($heures > $this->max_heures){
                $this->context->addViolation($constraint->message2, array('%number%' => $this->max_heures,'%stagiaire%' => $stagiaire));
            }
        } 
    }
}