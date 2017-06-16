<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

/**
 * Serie
 */
class Serie
{
    private $id;

    private $title;

    private $description;

    private $poster;

    private $serieActors;

    private $favoris;

    private $critics;

    private $serieTypes;

    private $episodes;

    private $airsDayOfWeek;

    private $airsTime;

    private $creationDate;

    private $modificationDate;

    private $isValid;

    public function __construct()
    {
        $this->critics = new ArrayCollection();
        $this->episodes = new ArrayCollection();
        $this->serieActors = new ArrayCollection();
        $this->serieTypes = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->modificationDate = new \DateTime();
        $this->isValid = false;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     **/
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAirsDayOfWeek()
    {
        return $this->airsDayOfWeek;
    }

    /**
     * @param mixed $airsDayOfWeek
     **/
    public function setAirsDayOfWeek($airsDayOfWeek)
    {
        $this->airsDayOfWeek = $airsDayOfWeek;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAirsTime()
    {
        return $this->airsTime;
    }

    /**
     * @param mixed $airsTime
     **/
    public function setAirsTime($airsTime)
    {
        $this->airsTime = $airsTime;
        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    public function setModificationDate()
    {
        $this->modificationDate = new \DateTime();
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * @param Episode $episode
     **/
    public function setEpisodes(Episode $episode)
    {
        $this->episodes->add($episode);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerieTypes()
    {
        $array = [];

        foreach($this->serieTypes as $result)
        {
            $array[] = $result;
        }

        return $array;
    }

    /**
     * @param mixed $serieTypes
     **/
    public function setSerieTypes(SerieType $serieTypes)
    {
        $this->serieTypes->add($serieTypes);
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
     * @param ArrayCollection $critic
     **/
    public function setCritics(Critic $critic)
    {
        $this->critics->add($critic);
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
        $this->favoris->add($favoris);
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

