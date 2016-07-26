<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer", indexes={@ORM\Index(name="FK_customer_category", columns={"category"})})
 * @ORM\Entity
 */
class Customer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=50, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=150, nullable=false)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="account_expired", type="datetime", nullable=true)
     */
    private $accountExpired = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_extension", type="string", length=10, nullable=false)
     */
    private $avatarExtension;

    /**
     * @var \Admin\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;

    public function __construct()
        {
            $date = new \DateTime();
            $date->modify('+1 month');
            $this->accountExpired = $date;
        }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Customer
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
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
     * Set email
     *
     * @param string $email
     *
     * @return Customer
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
     * Set accountExpired
     *
     * @param \DateTime $accountExpired
     *
     * @return Customer
     */
    public function setAccountExpired($accountExpired)
    {
        $this->accountExpired = $accountExpired;

        return $this;
    }

    /**
     * Get accountExpired
     *
     * @return \DateTime
     */
    public function getAccountExpired()
    {
        return $this->accountExpired;
    }

    /**
     * Set avatarExtension
     *
     * @param string $avatarExtension
     *
     * @return Customer
     */
    public function setAvatarExtension($avatarExtension)
    {
        $this->avatarExtension = $avatarExtension;

        return $this;
    }

    /**
     * Get avatarExtension
     *
     * @return string
     */
    public function getAvatarExtension()
    {
        return $this->avatarExtension;
    }

    /**
     * Set category
     *
     * @param \Admin\Entity\Category $category
     *
     * @return Customer
     */
    public function setCategory(\Admin\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Admin\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
