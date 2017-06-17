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
        $fav = $this->findOneBy(["id" => $favorisId]);


        $this->getEntityManager()->remove($fav);
        $this->getEntityManager()->flush();
    }

    public function wall($userId)
    {
        $favs = $this->getFavorisByUserId($userId);

        if (count($favs))
        {
            $DDArray = [];

            foreach ($favs as $fav)
            {
                $serie = $fav->getSerie();

                $criticInArray = $this->getEntityManager()->getRepository("MainBundle:Critic")->getLastUploadedAndValidatedCriticFromSerie($serie);

                if (count($criticInArray) === 0)
                {
                    continue;
                }
                else
                {
                    $critic = $criticInArray[0];

                    $array = ["serie" => $serie, "critic" => $critic];

                    $DDArray[] = $array;
                }
            }

            return $DDArray;
        }
        else
        {
            return null;
        }
    }

    public function checkIfSerieIsInFav($serieId, $userId)
    {
        $user = $this->getEntityManager()->getRepository("MainBundle:User")->getUserById($userId);
        $serie = $this->getEntityManager()->getRepository("MainBundle:Serie")->getSerieWithId($serieId);

        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("f")
            ->from("MainBundle:Favoris", "f")
            ->where("f.serie = :serie")
            ->andWhere("f.user = :user")
            ->setParameter(":serie", $serie)
            ->setParameter(":user", $user)
            ->getQuery()
            ->getResult();

        if (count($isHereOrNot) > 0)
        {
            return true;
        }


        return false;
    }

    public function TempFakeFav($userId1, $userId2)
    {
        $series = $this->getEntityManager()->getRepository("MainBundle:Serie")->getSeries();

        $i = 0;

        foreach ($series as $serie)
        {
            $i++;

            if (rand(0, 100) > 60)
            {
                if ($i % 2 === 0)
                {
                    $this->addSerie($userId1, $serie->getId()->__toString());
                }
                else
                {
                    $this->addSerie($userId2, $serie->getId()->__toString());
                }
            }
        }
    }
}
