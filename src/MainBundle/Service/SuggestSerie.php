<?php
namespace MainBundle\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

class SuggestSerie extends  Controller
{
    private $manager;

    public function __construct(EntityManager $em)
    {
        $this->manager = $em;
    }

    public function getSuggestion($userId)
    {
        // Récupération des favoris de l'utilisateurs
        $userFavs = $this->manager->GetRepository("MainBundle:Favoris")->getFavorisByUserId($userId);

        $result = [];
        $array = [];

        // Pour chaque objet favoris, on stocke les séries
        foreach($userFavs as $userFav)
        {
            array_push($array, $userFav->getSerie());
        }

        $bool = true;

        while($bool)
        {
            // On sélectionne une série parmis toutes celles stocker
            $chosenSerie = $array[array_rand($array)];

            // On stocke les informations de la série de départ
            $result[] = $chosenSerie;

            // On récupère les type de la série choisie
            $arraySerieTypes = $chosenSerie->getSerieTypes();

            if(count($arraySerieTypes) === 0)
            {
                continue;
            }
            else
            {
                $rand = array_rand($arraySerieTypes);

                // On en choisie un au hazard
                $chosenSerieType = $arraySerieTypes[$rand];

                // On récupère sont nom
                $typeName = $chosenSerieType->getType()->getName();

                // A partir du nom on récupère les sériesType qui ont le même type
                $serieTypes = $this->manager
                    ->getRepository("MainBundle:SerieType")
                    ->getSeriesTypeByType($typeName);


                // Pour chaque sérieType
                foreach($serieTypes as $serieType)
                {
                    if($serieType->getSerie() !== $chosenSerie)
                        array_push($result, $serieType->getSerie());
                }


                $bool = false;
            }
        }

        return $result;
    }
}
?>