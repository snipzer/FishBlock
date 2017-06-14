<?php

namespace MainBundle\Repository;
use MainBundle\Entity\Serie;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * SerieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SerieRepository extends \Doctrine\ORM\EntityRepository
{
    // Renvois toutes les séries en base
    public function getSeries()
    {
        return $this->findAll();
    }

    // Renvois les informations d'une série grâce a sont uuid
    public function getSerieWithId($serieId)
    {
        return $this->findOneBy(["id" => $serieId]);
    }

    public function postSerie($array)
    {
        if(
            (is_null($array["title"]) || is_null($array["description"]) || is_null($array["poster"]) || is_null($array["airsDayOfWeek"]) || is_null($array["airsTime"]))
            && (is_string($array["title"]) && is_string($array["description"]) && is_string($array["poster"]) && is_string($array["airsDayOfWeek"]) && is_string($array["airsTime"]))
        )
        {
            return false;
        }

        $manager = $this->getEntityManager();

        $serie = new Serie();
        $serie->setTitle($array["title"])
            ->setDescription($array["description"])
            ->setPoster($array["poster"])
            ->setAirsDayOfWeek($array["airsDayOfWeek"])
            ->setAirsTime($array["airsTime"]);

        $manager->persist($serie);
        $manager->flush();

        return true;
    }

    // Renvois les dernières séries publier
    public function getSeriesSortByDate()
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select("s")
            ->from("MainBundle:Serie", "s")
            ->orderBy('s.creationDate', "ASC")->getQuery()->getResult();
    }

    // Calcule et renvois la note de la série en fonction de la moyenne des notes de ces critiques
    public function getSerieNotation($serieId)
    {
        $critics = $this->getEntityManager()->getRepository("MainBundle:Critic")->getValidatedCriticsFromSerie($serieId);
        $Notes = [];
        foreach($critics as $critic)
        {
            array_push($Notes, $critic->getNote());
        }

        return round((array_sum($Notes)/count($Notes)));
    }

    // Renvois toutes les modification de séries en attente de validation
    public function getModifSeries() {}

    // Renvois les séries qui n'ont pas de doublon au niveau de l'uuid et qui sont non validée
    public function getNewSeries()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT s
              FROM MainBundle\Entity\Serie s
              ORDER BY s.creationDate DESC'
        )->setMaxResults(10)->getResult();
    }

    // Suppression d'une série
    public function deleteSerie($serieId)
    {
        $serie = $this->getSerieWithId($serieId);

        $this->getEntityManager()->remove($serie);
        $this->getEntityManager()->flush();
    }

    public function checkIfSerieAlreadyHere($serieTitle)
    {
        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("s")
            ->from("MainBundle:Serie", "s")
            ->where("s.title = :sTitle")
            ->setParameter(":sTitle", $serieTitle)
            ->getQuery()
            ->getResult();

        if(count($isHereOrNot))
            return false;

        return true;
    }

}
