<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Actor
 */
class Actor
{
    private $id;

    private $name;

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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     **/
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}

