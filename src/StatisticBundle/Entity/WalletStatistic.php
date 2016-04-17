<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.06.2015
 * Time: 19:10
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class WalletStatistic
 * @package Matrix\StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="wallet_statistic")
 */
class WalletStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="walletStatistic", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum;

    /**
     * 0 - output
     * 1 - input
     * @ORM\Column(type="boolean")
     */
    protected $type;

    /**
     * 0 - wait
     * 1 - done
     * 2 - refund
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $system;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $account;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $hash;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return WalletStatistic
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
     * Set sum
     *
     * @param string $sum
     *
     * @return WalletStatistic
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
     * Set type
     *
     * @param boolean $type
     *
     * @return WalletStatistic
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
     * Set status
     *
     * @param integer $status
     *
     * @return WalletStatistic
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
     * Set system
     *
     * @param string $system
     *
     * @return WalletStatistic
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return WalletStatistic
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return WalletStatistic
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return WalletStatistic
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
}
