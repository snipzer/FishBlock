<?php

namespace MainBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Critic
 */
class Critic
{
    private $id;

    private $note;

    private $content;

    private $title;

    private $postedThe;

    private $isValid;

    private $user;

    private $serie;

    private $criticNotations;

    public function __construct()
    {
        $this->criticNotations = new ArrayCollection();
        $this->isValid = false;
        $this->postedThe = new Date();
    }

    /**
     * @return ArrayCollection
     */
    public function getCriticNotations()
    {
        return $this->criticNotations;
    }

    /**
     * @param ArrayCollection $criticNotations
     **/
    public function setCriticNotations($criticNotations)
    {
        $this->criticNotations = $criticNotations;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     **/
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostedThe()
    {
        return $this->postedThe;
    }

    /**
     * @param mixed $postedThe
     **/
    public function setPostedThe(DateTime $postedThe)
    {
        $this->postedThe = $postedThe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     **/
    public function setUser(User $user)
    {
        $this->user = $user;
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
     * Set note
     *
     * @param int $note
     *
     * @return Critic
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getScore()
    {
        return $this->note;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Critic
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return Critic
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }
}

