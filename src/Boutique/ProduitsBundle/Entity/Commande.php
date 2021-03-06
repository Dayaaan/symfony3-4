<?php

namespace Boutique\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="Boutique\ProduitsBundle\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    
    /**
     * @var string
     *
     * @ORM\Column(name="states", type="string", length=255)
     */
    private $states;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Boutique\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount", type="float")
     */
    private $totalAmount;

    /**
     * @ORM\Column(name="charge_id", type="string", length=255, nullable=true)
     */
    protected $chargeId;

    /**
     * @var bool
     * @ORM\Column(name="paiement_status", type="boolean")
     */
    protected $paiementStatus;


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
     * @return Commande
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

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Commande
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Commande
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Commande
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return Commande
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Commande
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function __construct() {

        $this->createdAt = new \DateTime();

    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Commande
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }





    /**
     * Set user
     *
     * @param \Boutique\UserBundle\Entity\User $user
     *
     * @return Commande
     */
    public function setUser(\Boutique\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Boutique\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set states
     *
     * @param string $states
     *
     * @return Commande
     */
    public function setStates($states)
    {
        $this->states = $states;

        return $this;
    }

    /**
     * Get states
     *
     * @return string
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Set chargeId
     *
     * @param string $chargeId
     *
     * @return Commande
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * Set paiementStatus
     *
     * @param boolean $paiementStatus
     *
     * @return Commande
     */
    public function setPaiementStatus($paiementStatus)
    {
        $this->paiementStatus = $paiementStatus;

        return $this;
    }

    /**
     * Get paiementStatus
     *
     * @return boolean
     */
    public function getPaiementStatus()
    {
        return $this->paiementStatus;
    }

    /**
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return Commande
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
}
