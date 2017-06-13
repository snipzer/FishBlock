<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 */
class User extends BaseUser
{
    protected $id;

    private $lastName;

    private $firstName;

    private $birthdate;

    private $profilePicture;

    private $criticNumber;

    private $isValid;

    private $favoris;

    private $critics;

    private $criticNotations;

    public function __construct()
    {
        parent::__construct();
        $this->critics = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->criticNotations = new ArrayCollection();
        $this->criticNumber = 0;
        $this->isValid = true;
    }

    /**
     * @return ArrayCollection
     */
    public function getCriticNotations()
    {
        return $this->criticNotations;
    }

    /**
     * @param CriticNotation $criticNotation
     **/
    public function setCriticNotations($criticNotation)
    {
        $this->criticNotations->add($criticNotation);
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
     * @param Critic $critic
     **/
    public function setCritics(Critic $critic)
    {
        $this->critics->add($critic);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param Favoris $favoris
     **/
    public function setFavoris(Favoris $favoris)
    {
        $this->favoris->add($favoris);
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set profilePicture
     *
     * @param string $profilePicture
     *
     * @return User
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set criticNumber
     *
     * @param integer $criticNumber
     *
     * @return User
     */
    public function setCriticNumber($criticNumber)
    {
        $this->criticNumber = $criticNumber;

        return $this;
    }

    /**
     * Get criticNumber
     *
     * @return int
     */
    public function getCriticNumber()
    {
        return $this->criticNumber;
    }
    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return User
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