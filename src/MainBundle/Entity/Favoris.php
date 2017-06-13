<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Favoris
 */
class Favoris
{
    private $id;

    private $user;

    private $serie;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Object $user
     **/
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param Object $serie
     **/
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

