<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 10:03 AM
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use UserBundle\Entity\User;

/**
 * Class LoginListener
 */
class LoginListener
{
    private $em;
    private $container;

    /**
     * LoginListener constructor.
     *
     * @param EntityManager $doctrine
     * @param $service
     */
    public function __construct(EntityManager $doctrine, $service)
    {
        $this->em           = $doctrine;
        $this->container    = $service;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        /** @var $user User */
        $user       = $event->getAuthenticationToken()->getUser();

        if (!$user->hasRole('ROLE_ADMIN')) {
            /** @var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->container->get('request');

            $user->setLastIp($request->getClientIp());
            $this->em->flush($user);
        }
    }
}
