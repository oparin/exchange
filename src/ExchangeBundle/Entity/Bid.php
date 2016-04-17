<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/14/15
 * Time: 11:48 AM
 */

namespace ExchangeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use WalletBundle\Entity\TypeBalance;

/**
 * Class Bid
 * @package ExchangeBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="bids")
 */
class Bid
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="bids")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * 0 - Buying
     * 1 - Sale
     *
     * @ORM\Column(type="boolean")
     */
    protected $type;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $quantity;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commission;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status = 0;

    /**
     * @ORM\ManyToOne(targetEntity="WalletBundle\Entity\TypeBalance", inversedBy="bids")
     * @ORM\JoinColumn(name="balance_type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $typeBalance;

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
     * Set type
     *
     * @param boolean $type
     *
     * @return Bid
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Bid
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Bid
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Bid
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return Bid
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Bid
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Bid
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Bid
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set typeBalance
     *
     * @param \WalletBundle\Entity\TypeBalance $typeBalance
     *
     * @return Bid
     */
    public function setTypeBalance(TypeBalance $typeBalance = null)
    {
        $this->typeBalance = $typeBalance;

        return $this;
    }

    /**
     * Get typeBalance
     *
     * @return \WalletBundle\Entity\TypeBalance
     */
    public function getTypeBalance()
    {
        return $this->typeBalance;
    }
}
