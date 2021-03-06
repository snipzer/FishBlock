<?php

namespace MainBundle\Repository;

use MainBundle\Entity\Critic;
use MainBundle\Entity\CriticNotation;

/**
 * CriticNotationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CriticNotationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNotationByCriticId($criticId)
    {
        $critic = $this->getEntityManager()->getRepository("MainBundle:Critic")->getCriticByCriticId($criticId);

        return $this->getEntityManager()->createQueryBuilder()
            ->select("cn")
            ->from("MainBundle:CriticNotation", "cn")
            ->where("cn.critic = :critic")
            ->setParameter(":critic", $critic)
            ->getQuery()->getScalarResult();

    }

    public function getLikedByCritic(Critic $critic)
    {
        return count($this->getEntityManager()->createQueryBuilder()
            ->select("cn")
            ->from("MainBundle:CriticNotation", "cn")
            ->where("cn.critic = :critic")
            ->andWhere("cn.isLike = true")
            ->setParameter(":critic", $critic)
            ->getQuery()->getResult());

    }

    public function getUnLikedByCritic(Critic $critic)
    {
        return count($this->getEntityManager()->createQueryBuilder()
            ->select("cn")
            ->from("MainBundle:CriticNotation", "cn")
            ->where("cn.critic = :critic")
            ->andWhere("cn.isLike = false")
            ->setParameter(":critic", $critic)
            ->getQuery()->getResult());

    }

    public function addNotation($criticId, $userId, $liked)
    {
        $critic = $this->getEntityManager()->getRepository("MainBundle:Critic")->getCriticByCriticId($criticId);
        $user = $this->getEntityManager()->getRepository("MainBundle:User")->getUserById($userId);

        $notation = new CriticNotation();
        $notation->setUser($user)->setCritic($critic)->setIsLike($liked);

        $this->getEntityManager()->persist($notation);
        $this->getEntityManager()->flush();
    }

    public function checkIfNotationAlreadyHere($criticId, $userId)
    {
        $user = $this->getEntityManager()->getRepository("MainBundle:User")->getUserById($userId);

        $critic = $this->getEntityManager()->getRepository("MainBundle:Critic")->getCriticByCriticId($criticId);

        $isHereOrNot = $this->getEntityManager()->createQueryBuilder()
            ->select("cn")
            ->from("MainBundle:CriticNotation", "cn")
            ->where("cn.critic = :critic")
            ->andWhere("cn.user = :user")
            ->setParameter(":critic", $critic)
            ->setParameter(":user", $user)
            ->getQuery()
            ->getResult();


        if(count($isHereOrNot) <= 0)
        {
            return false;
        }

        return $isHereOrNot;
    }
}
