<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieActor
 */
class SerieActor
{
    /**
     * @var int
     */
    private $id;

    private $actor;

    private $serie;

    private $role;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     **/
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @param ArrayCollection $actor
     **/
    public function setActor(Actor $actor)
    {
        $this->actor = $actor;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param ArrayCollection $serie
     **/
    public function setSerie(Serie $serie)
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

