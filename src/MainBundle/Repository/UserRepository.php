<?php

namespace MainBundle\Repository;
use MainBundle\Entity\User;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUsers()
    {
        return $this->findAll();
    }

    public function getUserById($userId)
    {
        return $this->findOneBy(["id" => $userId]);
    }

    public function createUser($email, $password, $userName, $firstName, $lastName, $role)
    {
        $user = new User();
        $user->setEmail($email)
            ->setUsernameCanonical($userName)
            ->setUsername($userName)
            ->setLastName($lastName)
            ->setFirstName($firstName)
            ->setPlainPassword($password)
            ->setRoles([$role])
//            ->setEnabled(true)
            ->setBirthdate(new \DateTime());

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    // Bannis l'utilisateur
    public function banUser($userId)
    {
        $user = $this->getUserById($userId);
        $user->setIsValid(false);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function TempFakeUser()
    {
        $user1 = [
            "email" => "toto@gmail.com",
            "password" => "123456789",
            "userName" => "TotoMaster",
            "lastName" => "toto",
            "firstName" => "master",
            "role" => "ROLE_USER"
        ];

        $user2 = [
            "email" => "snipzer@gmail.com",
            "password" => "123456789",
            "userName" => "Snipzer",
            "lastName" => "snip",
            "firstName" => "zer",
            "role" => "ROLE_ADMIN"
        ];

        $user = $this->createUser($user1["email"], $user1["password"], $user1["userName"], $user1["firstName"], $user1["lastName"], $user1["role"]);

        $user->setEnabled(true);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        $user = $this->createUser($user2["email"], $user2["password"], $user2["userName"], $user2["firstName"], $user2["lastName"], $user2["role"]);

        $user->setEnabled(true);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();


        return [$this->findBy(["username" => "TotoMaster"]), $this->findBy(["username" => "Snipzer"])];
    }
}
