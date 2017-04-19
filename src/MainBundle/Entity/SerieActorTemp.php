<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * SerieActorTemp
 */
class SerieActorTemp
{
    /**
     * @var int
     */
    private $id;

    private $actor;

    private $serieTemp;


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
    public function getSerieTemp()
    {
        return $this->serieTemp;
    }

    /**
     * @param ArrayCollection $serieTemp
     **/
    public function setSerieTemp(SerieTemp $serieTemp)
    {
        $this->serieTemp = $serieTemp;
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

