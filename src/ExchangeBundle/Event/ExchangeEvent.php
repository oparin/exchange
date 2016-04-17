<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/15/15
 * Time: 3:25 PM
 */

namespace ExchangeBundle\Event;

use ExchangeBundle\Entity\Bid;
use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class ExchangeEvent
 * @package ExchangeBundle\Event
 */
class ExchangeEvent extends Event
{
    protected $sellBid;
    protected $buyBid;
    protected $user;

    /**
     * ExchangeEvent constructor.
     * @param Bid  $sellBid
     * @param Bid  $buyBid
     * @param User $user
     */
    public function __construct(Bid $sellBid, Bid $buyBid, User $user)
    {
        $this->sellBid  = $sellBid;
        $this->buyBid   = $buyBid;
        $this->user     = $user;
    }

    /**
     * @return Bid
     */
    public function getSellBid()
    {
        return $this->sellBid;
    }

    /**
     * @return Bid
     */
    public function getBuyBid()
    {
        return $this->buyBid;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
