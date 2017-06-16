<?php

namespace MainBundle\Repository;

/**
 * TypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getTypes()
    {
        return $this->findAll();
    }

    public function getTypeById($typeId)
    {
        return $this->findOneBy(["id" => $typeId]);
    }

    public function checkIfTypeAlreadyHere($typeName)
    {
        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("t")
            ->from("MainBundle:Type", "t")
            ->where("t.name = :tName")
            ->setParameter(":tName", $typeName)
            ->getQuery()
            ->getResult();


        if(count($isHereOrNot))
            return false;

        return true;
    }

    public function getTypeByName($typeName)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select("t")
            ->from("MainBundle:Type", "t")
            ->where("t.name = :name")
            ->setParameter(":name", $typeName)
            ->getQuery()->getResult();
    }

    public function getOneTypeByName($typeName)
    {
        return $this->findOneBy(["name" => $typeName]);
    }
}
