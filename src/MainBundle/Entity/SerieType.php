<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieType
 */
class SerieType
{
    /**
     * @var int
     */
    private $id;

    private $type;

    private $serie;

    /**
     * @return ArrayCollection
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ArrayCollection $type
     **/
    public function setType(Type $type)
    {
        $this->type = $type;
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

