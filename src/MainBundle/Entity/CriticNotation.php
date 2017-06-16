<?php

namespace MainBundle\Entity;

/**
 * CriticNotation
 */
class CriticNotation
{
    private $id;

    private $isLike;

    private $critic;

    private $user;

    /**
     * @return mixed
     */
    public function getCritic()
    {
        return $this->critic;
    }

    /**
     * @param mixed $critic
     **/
    public function setCritic($critic)
    {
        $this->critic = $critic;
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
    public function setUser($user)
    {
        $this->user = $user;
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
     * Set isLike
     *
     * @param boolean $isLike
     *
     * @return CriticNotation
     */
    public function setIsLike($isLike)
    {
        $this->isLike = $isLike;

        return $this;
    }

    /**
     * Get isLike
     *
     * @return bool
     */
    public function getIsLike()
    {
        return $this->isLike;
    }
}

