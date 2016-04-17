<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 07.04.16
 * Time: 9:35
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class MiningHistory
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mining_history")
 */
class MiningHistory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="miningHistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * 0 - Buy mining rights
     * 1 - Send pool
     * 2 - Sell
     * 3 - Convert
     *
     * @ORM\Column(type="integer")
     */
    protected $transaction;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights")
     */
    protected $miningRights;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights_in_work")
     */
    protected $miningRightsInWork;

    /**
     * @ORM\Column(type="decimal", scale=2, name="pool_wallet")
     */
    protected $poolWallet;

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
     * @return MiningHistory
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
     * Set transaction
     *
     * @param integer $transaction
     *
     * @return MiningHistory
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return integer
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return MiningHistory
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set miningRights
     *
     * @param string $miningRights
     *
     * @return MiningHistory
     */
    public function setMiningRights($miningRights)
    {
        $this->miningRights = $miningRights;

        return $this;
    }

    /**
     * Get miningRights
     *
     * @return string
     */
    public function getMiningRights()
    {
        return $this->miningRights;
    }

    /**
     * Set miningRightsInWork
     *
     * @param string $miningRightsInWork
     *
     * @return MiningHistory
     */
    public function setMiningRightsInWork($miningRightsInWork)
    {
        $this->miningRightsInWork = $miningRightsInWork;

        return $this;
    }

    /**
     * Get miningRightsInWork
     *
     * @return string
     */
    public function getMiningRightsInWork()
    {
        return $this->miningRightsInWork;
    }

    /**
     * Set poolWallet
     *
     * @param string $poolWallet
     *
     * @return MiningHistory
     */
    public function setPoolWallet($poolWallet)
    {
        $this->poolWallet = $poolWallet;

        return $this;
    }

    /**
     * Get poolWallet
     *
     * @return string
     */
    public function getPoolWallet()
    {
        return $this->poolWallet;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return MiningHistory
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
