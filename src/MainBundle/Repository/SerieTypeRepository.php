<?php

namespace MainBundle\Repository;

/**
 * SerieTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SerieTypeRepository extends \Doctrine\ORM\EntityRepository
{

    public function getSeriesTypeByType($typeName)
    {
        $type = $this->getEntityManager()->getRepository("MainBundle:Type")->getTypeByName($typeName);

        return $this->getEntityManager()->createQueryBuilder()
            ->select("st")
            ->from("MainBundle:SerieType", "st")
            ->where("st.type = :type")
            ->setParameter(":type", $type)
            ->setMaxResults(2)->getQuery()->getResult();
    }
}
