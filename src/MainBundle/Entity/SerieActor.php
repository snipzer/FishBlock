<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieActor
 */
class SerieActor
{
    private $id;

    private $actor;

    private $serie;

    private $role;

    private $creationDate;

    private $modificationDate;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->modificationDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return mixed
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    public function setModificationDate()
    {
        $this->modificationDate = new \DateTime();
        return $this;
    }

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
     * @return Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @param Actor $actor
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

