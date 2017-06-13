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

    public function checkIfActorAlreadyHere($actorName)
    {
        if($this->findBy(["name" => $actorName]))
        {
            return true;
        }
        return false;
    }
}
