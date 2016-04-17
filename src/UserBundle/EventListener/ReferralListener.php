<?php
/**
 * Created by PhpStorm.
 * User: oparin
 * Date: 7/26/15
 * Time: 11:53 AM
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class ReferralListener
 * @package Matrix\UserBundle\EventListener
 */
class ReferralListener implements EventSubscriberInterface
{
    protected $session;
    /**
     * ReferralListener constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session      = $session;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->get('ref')) {
            if ($request->get('ref') != 'admin') {
                $this->session->set('referral', $request->get('ref'));
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 1)),
        );
    }
}
