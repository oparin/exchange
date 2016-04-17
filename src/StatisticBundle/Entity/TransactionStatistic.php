<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 9:41 AM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class TransactionStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="transaction_statistic")
 */
class TransactionStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="transactionStatistic")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     *
     * 0 - withdraw
     * 1 - deposit
     * 2 - buy status
     * 3 - sale bid
     * 4 - buy bid
     * 5 - delete sale bid
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_wallet")
     */
    protected $mainWallet;

    /**
     * @ORM\Column(type="decimal", scale=2, name="bonus_wallet")
     */
    protected $bonusWallet;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_account")
     */
    protected $mainAccount;

    /**
     * @ORM\Column(type="decimal", scale=2, name="bonus_account")
     */
    protected $bonusAccount;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_ethereum")
     */
    protected $mainEthereum;

    /**
     * @ORM\Column(type="decimal", scale=2, name="bonus_ethereum")
     */
    protected $bonusEthereum;

    /**
     * TransactionStatistic constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set type
     *
     * @param integer $type
     *
     * @return TransactionStatistic
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return TransactionStatistic
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
     * Set mainWallet
     *
     * @param string $mainWallet
     *
     * @return TransactionStatistic
     */
    public function setMainWallet($mainWallet)
    {
        $this->mainWallet = $mainWallet;

        return $this;
    }

    /**
     * Get mainWallet
     *
     * @return string
     */
    public function getMainWallet()
    {
        return $this->mainWallet;
    }

    /**
     * Set bonusWallet
     *
     * @param string $bonusWallet
     *
     * @return TransactionStatistic
     */
    public function setBonusWallet($bonusWallet)
    {
        $this->bonusWallet = $bonusWallet;

        return $this;
    }

    /**
     * Get bonusWallet
     *
     * @return string
     */
    public function getBonusWallet()
    {
        return $this->bonusWallet;
    }

    /**
     * Set mainAccount
     *
     * @param string $mainAccount
     *
     * @return TransactionStatistic
     */
    public function setMainAccount($mainAccount)
    {
        $this->mainAccount = $mainAccount;

        return $this;
    }

    /**
     * Get mainAccount
     *
     * @return string
     */
    public function getMainAccount()
    {
        return $this->mainAccount;
    }

    /**
     * Set bonusAccount
     *
     * @param string $bonusAccount
     *
     * @return TransactionStatistic
     */
    public function setBonusAccount($bonusAccount)
    {
        $this->bonusAccount = $bonusAccount;

        return $this;
    }

    /**
     * Get bonusAccount
     *
     * @return string
     */
    public function getBonusAccount()
    {
        return $this->bonusAccount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return TransactionStatistic
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return TransactionStatistic
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
     * Set mainEthereum
     *
     * @param string $mainEthereum
     *
     * @return TransactionStatistic
     */
    public function setMainEthereum($mainEthereum)
    {
        $this->mainEthereum = $mainEthereum;

        return $this;
    }

    /**
     * Get mainEthereum
     *
     * @return string
     */
    public function getMainEthereum()
    {
        return $this->mainEthereum;
    }

    /**
     * Set bonusEthereum
     *
     * @param string $bonusEthereum
     *
     * @return TransactionStatistic
     */
    public function setBonusEthereum($bonusEthereum)
    {
        $this->bonusEthereum = $bonusEthereum;

        return $this;
    }

    /**
     * Get bonusEthereum
     *
     * @return string
     */
    public function getBonusEthereum()
    {
        return $this->bonusEthereum;
    }
}
