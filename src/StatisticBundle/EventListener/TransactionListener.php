<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 10:23 AM
 */

namespace StatisticBundle\EventListener;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\TransactionStatistic;
use StatisticBundle\Event\TransactionEvent;
use UserBundle\Entity\User;

/**
 * Class TransactionListener
 * @package StatisticBundle\EventListener
 */
class TransactionListener
{
    protected $em;

    /**
     * RegisterListener constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em       = $em;
    }

    /**
     * @param TransactionEvent $event
     */
    public function transaction(TransactionEvent $event)
    {
        /** @var $user User */
        $user           = $event->getUser();
        $mainWallet     = $event->getMainWallet();
        $mainAccount    = $event->getMainAccount();
        $currency       = $user->getCurrency();
        $mainEthereum   = $currency[0]->getSum();
        $bonusWallet    = $event->getBonusWallet();
        $bonusAccount   = $event->getBonusAccount();
        $bonusEthereum  = $currency[2]->getSum();
        $type           = $event->getType();
        $sum            = $event->getSum();

        $transaction    = new TransactionStatistic();
        $transaction->setUser($user);
        $transaction->setMainWallet($mainWallet);
        $transaction->setMainAccount($mainAccount);
        $transaction->setMainEthereum($mainEthereum);
        $transaction->setBonusWallet($bonusWallet);
        $transaction->setBonusAccount($bonusAccount);
        $transaction->setBonusEthereum($bonusEthereum);
        $transaction->setType($type);
        $transaction->setSum($sum);

        $this->em->persist($transaction);
        $this->em->flush($transaction);
    }
}
