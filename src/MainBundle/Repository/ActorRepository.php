<?php

namespace MainBundle\Repository;

/**
 * ActorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActorRepository extends \Doctrine\ORM\EntityRepository
{
    public function getActors()
    {
        return $this->findAll();
    }

    public function getActorById($actorId)
    {
        return $this->findOneBy(["id" => $actorId]);
    }

    public function getActorByName($name)
    {
        return $this->findOneBy(["name" => $name]);
    }

    public function checkIfActorAlreadyHere($actorName)
    {
        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("a")
            ->from("MainBundle:Actor", "a")
            ->where("a.name = :aName")
            ->setParameter(":aName", $actorName)
            ->getQuery()
            ->getResult();


        if(count($isHereOrNot))
            return false;

        return true;
    }
}
