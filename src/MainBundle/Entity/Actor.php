<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Actor
 */
class Actor
{
    private $id;

    private $lastName;

    private $firstName;

    private $picture;

    private $serieActors;

    public function __construct()
    {
        $this->serieActors = new ArrayCollection();
        $this->serieActorTemps = new ArrayCollection();
    }



    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerieActors()
    {
        return $this->serieActors;
    }

    /**
     * @param mixed $serieActors
     **/
    public function setSerieActors(SerieActor $serieActors)
    {
        $this->serieActors = $serieActors;
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

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Actor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Actor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
}

