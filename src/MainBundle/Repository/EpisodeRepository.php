<?php

namespace MainBundle\Repository;

/**
 * EpisodeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EpisodeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEpisodes()
    {
        return $this->findAll();
    }

    public function getEpisodesFromSerie($serieId)
    {
        $serieRepository = $this->getEntityManager()->getRepository("MainBundle:Serie");
        $serie = $serieRepository->getSerieWithId($serieId);

        return $this->getEntityManager()->createQuery(
            'SELECT e
              FROM MainBundle\Entity\Episode e
              JOIN MainBundle\entity\Serie s
              WHERE e.serie = :serie
              ORDER BY e.episodeNumber ASC, e.seasonNumber ASC'
        )->setParameter('serie', $serie)->getResult();
    }

    // Renvois le dernier épisode d'une série choisie avec l'uuid
    public function getLastEpisodeFromSerie($serieId)
    {
        $serieRepository = $this->getEntityManager()->getRepository("MainBundle:Serie");
        $serie = $serieRepository->getSerieWithId($serieId);

        return $this->getEntityManager()->createQuery(
            'SELECT e
              FROM MainBundle\Entity\Episode e
              JOIN MainBundle\entity\Serie s
              WHERE e.serie = :serie
              ORDER BY e.episodeNumber DESC'
        )->setParameter('serie', $serie)->setMaxResults(1)->getResult();
    }

    public function checkIfEpisodeAlreadyHere($episodeName, $episodeNumber, $seasonNumber)
    {
        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("e")
            ->from("MainBundle:Episode", "e")
            ->where("e.title = :eTitle")
            ->andWhere("e.episodeNumber = :eEpisodeNumber")
            ->andWhere("e.seasonNumber = :eSeasonNumber")
            ->setParameters([
                ":eTitle" => $episodeName,
                ":eEpisodeNumber" => $episodeNumber,
                ":eSeasonNumber" => $seasonNumber
                ])
            ->getQuery()
            ->getResult();


        if(count($isHereOrNot))
            return false;

        return true;
    }
}
