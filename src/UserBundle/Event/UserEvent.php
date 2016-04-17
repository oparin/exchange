<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 10:25 AM
 */

namespace UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class UserEvent
 * @package UserBundle\Event
 */
class UserEvent extends Event
{
    protected $user;
    protected $ip;

    /**
     * UserEvent constructor.
     * @param User   $user
     * @param string $ip
     */
    public function __construct(User $user, $ip)
    {
        $this->user = $user;
        $this->ip   = $ip;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}
