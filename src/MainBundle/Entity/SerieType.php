<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieType
 */
class SerieType
{
    private $id;

    private $type;

    private $serie;

    private $creationDate;

    private $modificationDate;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->modificationDate = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * @param \DateTime $modificationDate
     **/
    public function setModificationDate()
    {
        $this->modificationDate = new \DateTime();
        return $this;
    }

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

