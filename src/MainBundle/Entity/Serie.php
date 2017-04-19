<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Serie
 */
class Serie
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

    private $serieActors;

    private $favoris;

    private $critics;

    private $serieTemps;

    private $serieTypes;

    private $episodes;

    public function __construct()
    {
        $this->critics = new ArrayCollection();
        $this->serieTemps = new ArrayCollection();
        $this->episodes = new ArrayCollection();
        $this->serieActors = new ArrayCollection();
        $this->serieTypes = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * @param ArrayCollection $episodes
     **/
    public function setEpisodes(Episode $episodes)
    {
        $this->episodes = $episodes;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSerieTemps()
    {
        return $this->serieTemps;
    }

    /**
     * @param ArrayCollection $serieTemps
     **/
    public function setSerieTemps(SerieTemp $serieTemps)
    {
        $this->serieTemps = $serieTemps;
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
     * @return ArrayCollection
     */
    public function getCritics()
    {
        return $this->critics;
    }

    /**
     * @param ArrayCollection $critics
     **/
    public function setCritics(Critic $critics)
    {
        $this->critics = $critics;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param mixed $favoris
     **/
    public function setFavoris(Favoris $favoris)
    {
        $this->favoris = $favoris;
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
     * Set title
     *
     * @param string $title
     *
     * @return Serie
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
     * @return Serie
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
     * @return Serie
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

