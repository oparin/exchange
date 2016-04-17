<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 10:11 AM
 */

namespace StatisticBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class TransactionEvent
 * @package StatisticBundle\Event
 */
class TransactionEvent extends Event
{
    protected $user;
    protected $sum;
    protected $mainWallet;
    protected $mainAccount;
    protected $bonusWallet;
    protected $bonusAccount;
    protected $type;

    /**
     * TransactionEvent constructor.
     * @param User  $user
     * @param float $sum
     * @param float $mainWallet
     * @param float $bonusWallet
     * @param float $mainAccount
     * @param float $bonusAccount
     * @param int   $type
     */
    public function __construct(User $user, $sum, $mainWallet, $bonusWallet, $mainAccount, $bonusAccount, $type)
    {
        $this->user         = $user;
        $this->mainWallet   = $mainWallet;
        $this->mainAccount  = $mainAccount;
        $this->bonusWallet  = $bonusWallet;
        $this->bonusAccount = $bonusAccount;
        $this->type         = $type;
        $this->sum          = $sum;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return float
     */
    public function getMainWallet()
    {
        return $this->mainWallet;
    }

    /**
     * @return float
     */
    public function getMainAccount()
    {
        return $this->mainAccount;
    }

    /**
     * @return float
     */
    public function getBonusWallet()
    {
        return $this->bonusWallet;
    }

    /**
     * @return float
     */
    public function getBonusAccount()
    {
        return $this->bonusAccount;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }
}
