<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 07.04.16
 * Time: 11:26
 */

namespace OfficeBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class LocaleListener
 * @package OfficeBundle\EventListener
 */
class LocaleListener
{
//    private $defaultLocale;
//    private $context;
//
//    /**
//     * @param string          $defaultLocale
//     * @param SecurityContext $securityContext
//     */
//    public function __construct($defaultLocale, SecurityContext $securityContext)
//    {
//        $this->defaultLocale = $defaultLocale;
//        $this->context = $securityContext;
//    }
//
//    /**
//     * kernel.request event. If a guest user doesn't have an opened session, locale is equal to
//     * "undefined" as configured by default in parameters.ini. If so, set as a locale the user's
//     * preferred language.
//     *
//     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
//     */
//    public function setLocaleForUnauthenticatedUser(GetResponseEvent $event)
//    {
//        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
//            return;
//        }
//        $request = $event->getRequest();
//        $locale = $request->cookies->get('locale');
//
//        $request->setLocale($locale);
//    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        $locale = $request->cookies->get('locale');
        $request->getSession()->set('_locale', $locale);
        $request->setLocale($locale);
        $request->setDefaultLocale($locale);
    }

}
