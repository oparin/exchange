<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.06.2015
 * Time: 19:46
 */

namespace WalletBundle\Event;

use UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WalletEvent
 * @package Matrix\WalletBundle\Event
 */
class WalletEvent extends Event
{
    protected $user;
    protected $sum;
    protected $type;
    protected $account;
    protected $hash;

    /**
     * @param User  $user
     * @param float $sum
     * @param null  $type
     * @param null  $account
     * @param null  $hash
     */
    public function __construct(User $user, $sum, $type = null, $account = null, $hash = null)
    {
        $this->user     = $user;
        $this->sum      = $sum;
        $this->type     = $type;
        $this->account  = $account;
        $this->hash     = $hash;
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
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return null
     */
    public function getHash()
    {
        return $this->hash;
    }
}