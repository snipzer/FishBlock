<?php

namespace MainBundle\Entity;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Critic
 */
class Critic
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $score;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $likeNumber;

    /**
     * @var int
     */
    private $dislikeNumber;

    private $title;

    private $postedThe;

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
     * @var bool
     */
    private $isValid;

    private $user;

    private $serie;

    public function __construct()
    {
        $this->isValid = false;
        $this->postedThe = new Date();
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
     * Set score
     *
     * @param float $score
     *
     * @return Critic
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
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
     * Set likeNumber
     *
     * @param integer $likeNumber
     *
     * @return Critic
     */
    public function setLikeNumber($likeNumber)
    {
        $this->likeNumber = $likeNumber;

        return $this;
    }

    /**
     * Get likeNumber
     *
     * @return int
     */
    public function getLikeNumber()
    {
        return $this->likeNumber;
    }

    /**
     * Set dislikeNumber
     *
     * @param integer $dislikeNumber
     *
     * @return Critic
     */
    public function setDislikeNumber($dislikeNumber)
    {
        $this->dislikeNumber = $dislikeNumber;

        return $this;
    }

    /**
     * Get dislikeNumber
     *
     * @return int
     */
    public function getDislikeNumber()
    {
        return $this->dislikeNumber;
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
