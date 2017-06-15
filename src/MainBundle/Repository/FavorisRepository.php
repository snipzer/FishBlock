<?php

namespace MainBundle\Repository;

use MainBundle\Entity\Favoris;

/**
 * FavorisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FavorisRepository extends \Doctrine\ORM\EntityRepository
{
    // Récupère les favoris d'un utilisateur
    public function getFavorisByUserId($userId)
    {
        $user = $this->getEntityManager()->getRepository("MainBundle:User")->getUserById($userId);

        return $this->getEntityManager()->createQueryBuilder()
            ->select("f")
            ->from("MainBundle:Favoris", "f")
            ->where("f.user = :user")
            ->setParameter(":user", $user)
            ->getQuery()->getResult();
    }

    // Ajout d'une série au favoris
    public function addSerie($userId, $serieId)
    {
        $user = $this->getEntityManager()->getRepository("MainBundle:User")->getUserById($userId);

        $serie = $this->getEntityManager()->getRepository("MainBundle:Serie")->getSerieWithId($serieId);

        $favoris = new Favoris();
        $favoris->setUser($user)->setSerie($serie);

        $this->getEntityManager()->persist($favoris);
        $this->getEntityManager()->flush();
    }

    // Retirer la série des favoris
    public function removeFavoris($favorisId)
    {
        $fav = $this->findOneBy($favorisId);

        $this->getEntityManager()->remove($fav);
        $this->getEntityManager()->flush();
    }

    public function wall($userId)
    {
        $favs = $this->getFavorisByUserId($userId);

        $DDArray = [];

        foreach($favs as $fav)
        {
            $serie = $fav->getSerie();

            $criticInArray = $this->getEntityManager()->getRepository("MainBundle:Critic")->getLastUploadedAndValidatedCriticFromSerie($serie);

            $critic = $criticInArray[0];

            $array = ["serie" => $serie, "critic" => $critic];

            $DDArray[] = $array;
        }

        return $DDArray;
    }
}
