<?php
namespace MainBundle\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

class SuggestSerie extends  Controller
{
    // TODO: Récuperer l'ensemble des favoris d'un utilisateur
    // TODO: Choisir une série aléatoire
    // TODO: Récupérer sont type
    // TODO: Faire une recherche de série avec ce type, en choisir deux et les renvoyer
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

        // On sélectionne une série parmis toutes celles stocker
        $chosenSerie = $array[array_rand($array)];





        $arraySerieTypes = $chosenSerie->getSerieTypes();

        $chosenSerieType = $arraySerieTypes[array_rand($arraySerieTypes)];

        $typeName = $chosenSerieType->getType()->getName();

        $series = $this->manager
            ->getRepository("MainBundle:SerieType")
            ->getSeriesTypeByType($typeName);


        $result[] = $chosenSerie->getTitle();



        foreach($series as $serie)
        {
            $result[] = $serie->getSerie()->getTitle();
        }

        echo "<pre>";
        var_dump($result);
        echo "</pre>";

        return $result;
    }
}

?>