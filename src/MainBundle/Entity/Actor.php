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
     * @return ArrayCollection
     */
    public function getSerieActors()
    {
        return $this->serieActors;
    }

    /**
     * @param SerieActor $serieActor
     **/
    public function setSerieActors(SerieActor $serieActor)
    {
        $this->serieActors->add($serieActor);
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

