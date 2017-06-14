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
        $userFavs = $this->manager->GetRepository("MainBundle:Favoris")->getFavorisByUserId($userId);

        $result = [];
        $array = [];
        foreach($userFavs as $userFav)
        {
            $array[] = $userFav->getSerie();
        }

        $chosenSerie = $array[rand(0, count($array)-1)];


        $arraySerieTypes = $chosenSerie->getSerieTypes();

        $chosenSerieType = $arraySerieTypes[rand(0, count($arraySerieTypes)-1)];

        $typeName = $chosenSerieType->getType()->getName();

        $series = $this->manager
            ->getRepository("MainBundle:SerieType")
            ->getSeriesByType($typeName);


        $result[] = $chosenSerie->getPoster();

        foreach($series as $serie)
        {
            $result[] = $serie->getPoster();
        }
        var_dump($result);
        return $result;
    }
}

?>