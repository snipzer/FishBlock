<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * SerieTemp
 */
class SerieTemp
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $poster;

    private $serie;

    private $serieActorTemps;

    private $serieTypeTemps;

    public function __construct()
    {
        $this->serieTypeTemps = new ArrayCollection();
        $this->serieActorTemps = new ArrayCollection();
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
    public function getSerieActorTemps()
    {
        return $this->serieActorTemps;
    }

    /**
     * @param mixed $serieActorTemps
     **/
    public function setSerieActorTemps(SerieActorTemp $serieActorTemps)
    {
        $this->serieActorTemps = $serieActorTemps;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
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

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SerieTemp
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SerieTemp
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return SerieTemp
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }
}

