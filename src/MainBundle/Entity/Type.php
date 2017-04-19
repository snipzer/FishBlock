<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Type
 */
class Type
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    private $serieTypes;

    private $serieTypeTemps;

    public function __construct()
    {
        $this->serieTypes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSerieTypeTemps()
    {
        return $this->serieTypeTemps;
    }

    /**
     * @param mixed $serieTypeTemps
     **/
    public function setSerieTypeTemps(SerieTypeTemp $serieTypeTemps)
    {
        $this->serieTypeTemps = $serieTypeTemps;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerieTypes()
    {
        return $this->serieTypes;
    }

    /**
     * @param mixed $serieTypes
     **/
    public function setSerieTypes(SerieType $serieTypes)
    {
        $this->serieTypes = $serieTypes;
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
     * Set name
     *
     * @param string $name
     *
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

