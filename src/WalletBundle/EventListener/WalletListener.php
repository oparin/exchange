<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.06.2015
 * Time: 19:56
 */

namespace WalletBundle\EventListener;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\WalletStatistic;
use WalletBundle\Event\WalletEvent;

/**
 * Class WalletListener
 * @package Matrix\WalletBundle\EventListener
 */
class WalletListener
{
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param WalletEvent $event
     */
    public function addFundsWallet(WalletEvent $event)
    {
        $user = $event->getUser();
        $sum  = $event->getSum();
        $type       = $event->getType();
        $account    = $event->getAccount();
        $hash       = $event->getHash();

        $statistic = new WalletStatistic();
        $statistic->setType(true);
        $statistic->setStatus(1);
        $statistic->setUser($user);
        $statistic->setDate(new \DateTime());
        $statistic->setSum($sum);
        $statistic->setSystem($type);
        $statistic->setAccount($account);
        $statistic->setHash($hash);

        $this->em->persist($statistic);
        $this->em->flush();
    }

    /**
     * @param WalletEvent $event
     */
    public function payoutWallet(WalletEvent $event)
    {
        $user       = $event->getUser();
        $sum        = $event->getSum();
        $type       = $event->getType();
        $account    = $event->getAccount();

        $statistic = new WalletStatistic();
        $statistic->setType(false);
        $statistic->setStatus(0);
        $statistic->setUser($user);
        $statistic->setDate(new \DateTime());
        $statistic->setSum($sum);
        $statistic->setSystem($type);
        $statistic->setAccount($account);

        $this->em->persist($statistic);
        $this->em->flush();
    }
}