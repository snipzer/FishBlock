<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieTypeTemp
 */
class SerieTypeTemp
{
    /**
     * @var int
     */
    private $id;

    private $type;

    private $serieTemp;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     **/
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerieTemp()
    {
        return $this->serieTemp;
    }

    /**
     * @param mixed $serieTemp
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

