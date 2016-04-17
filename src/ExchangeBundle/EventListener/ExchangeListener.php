<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/15/15
 * Time: 3:43 PM
 */

namespace ExchangeBundle\EventListener;

use Doctrine\ORM\EntityManager;
use ExchangeBundle\Entity\Bid;
use ExchangeBundle\Entity\Trade;
use ExchangeBundle\Event\ExchangeEvent;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use UserBundle\Entity\User;

/**
 * Class ExchangeListener
 * @package ExchangeBundle\EventListener
 */
class ExchangeListener
{
    protected $em;
    protected $dispatcher;

    /**
     * ExchangeListener constructor.
     * @param EntityManager            $em
     * @param TraceableEventDispatcher $dispatcher
     */
    public function __construct(EntityManager $em, $dispatcher)
    {
        $this->em           = $em;
        $this->dispatcher   = $dispatcher;
    }

    /**
     * @param ExchangeEvent $event
     */
    public function saleBid(ExchangeEvent $event)
    {
        $sellBid    = $event->getSellBid();
        $buyBid     = $event->getBuyBid();
        $user       = $event->getUser();
        $date       = new \DateTime();

        $buyCurrency = $this->em->getRepository('WalletBundle:UserCurrency')->findOneBy(array(
            'user'  => $buyBid->getUser(),
            'type'  => $buyBid->getTypeBalance(),
        ));

        $userWallet = $this->em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
            'user'  => $user,
            'type'  => $sellBid->getTypeBalance(),
        ));

        if ($buyBid->getQuantity() < $sellBid->getQuantity()) {
            // Change Sell Bid
            $sellBid->setQuantity($sellBid->getQuantity() - $buyBid->getQuantity());

            // Create new SellBid
            $newSellBid = new Bid();
            $newSellBid->setUser($user);
            $newSellBid->setQuantity($buyBid->getQuantity());
            $newSellBid->setStatus(true);
            $newSellBid->setType(true);
            $newSellBid->setCommission($sellBid->getCommission());
            $newSellBid->setPrice($sellBid->getPrice());
            $newSellBid->setSum($newSellBid->getQuantity() * $newSellBid->getPrice());
            $newSellBid->setDate($date);
            $newSellBid->setTypeBalance($sellBid->getTypeBalance());
            $this->em->persist($newSellBid);

            $userWallet->setSum($userWallet->getSum() + $newSellBid->getSum());

            // Change Buy Bid
            $buyBid->setStatus(true);
            $buyCurrency->setSum($buyCurrency->getSum() + $buyBid->getQuantity());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($newSellBid);
            $trade->setBuyBid($buyBid);
            $trade->setType(true);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $newSellBid->getSum(), 3);
        } elseif ($buyBid->getQuantity() > $sellBid->getQuantity()) {
            // Change Buy Bid
            $buyBid->setQuantity($buyBid->getQuantity() - $sellBid->getQuantity());
            $buyBid->setSum($buyBid->getQuantity() * $buyBid->getPrice());

            // Save Sell Bid
            $sellBid->setStatus(true);
            $sum = $sellBid->getPrice() * $sellBid->getQuantity();
            $sellBid->setDate($date);
            $sellBid->setSum($sum);
            $this->em->persist($sellBid);
            $userWallet->setSum($userWallet->getSum() + $sellBid->getSum());

            // Create new BuyBid
            $newBuyBid = new Bid();
            $newBuyBid->setUser($buyBid->getUser());
            $newBuyBid->setQuantity($sellBid->getQuantity());
            $newBuyBid->setStatus(true);
            $newBuyBid->setType(false);
            $newBuyBid->setCommission($buyBid->getCommission());
            $newBuyBid->setPrice($buyBid->getPrice());
            $newBuyBid->setSum($newBuyBid->getQuantity() * $newBuyBid->getPrice());
            $date   = new \DateTime();
            $newBuyBid->setDate($date);
            $newBuyBid->setTypeBalance($buyBid->getTypeBalance());
            $this->em->persist($newBuyBid);
            $buyCurrency->setSum($buyCurrency->getSum() + $newBuyBid->getQuantity());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($sellBid);
            $trade->setBuyBid($newBuyBid);
            $trade->setType(true);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $sum, 3);
        } elseif ($buyBid->getQuantity() == $sellBid->getQuantity()) {
            // Save Sell Bid
            $sellBid->setStatus(true);
            $sum = $sellBid->getPrice() * $sellBid->getQuantity();
            $sellBid->setDate($date);
            $sellBid->setSum($sum);
            $this->em->persist($sellBid);
            $userWallet->setSum($userWallet->getSum() + $sellBid->getSum());

            // Change Buy Bid
            $buyBid->setStatus(true);
            $buyCurrency->setSum($buyCurrency->getSum() + $buyBid->getQuantity());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($sellBid);
            $trade->setBuyBid($buyBid);
            $trade->setType(true);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $sum, 3);
        }
        $this->em->flush();
    }

    /**
     * @param ExchangeEvent $event
     */
    public function buyBid(ExchangeEvent $event)
    {
        $sellBid = $event->getSellBid();
        $buyBid = $event->getBuyBid();
        $user = $event->getUser();
        $date = new \DateTime();

        $sellWallet = $this->em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
            'user'  => $sellBid->getUser(),
            'type'  => $sellBid->getTypeBalance(),
        ));

        $userCurrency = $this->em->getRepository('WalletBundle:UserCurrency')->findOneBy(array(
            'user'  => $user,
            'type'  => $buyBid->getTypeBalance(),
        ));

        if ($buyBid->getQuantity() < $sellBid->getQuantity()) {
            // Change Sell Bid
            $sellBid->setQuantity($sellBid->getQuantity() - $buyBid->getQuantity());
            $sellBid->setSum($sellBid->getQuantity() * $sellBid->getPrice());

            // Create new SellBid
            $newSellBid = new Bid();
            $newSellBid->setUser($sellBid->getUser());
            $newSellBid->setQuantity($buyBid->getQuantity());
            $newSellBid->setStatus(true);
            $newSellBid->setType(true);
            $newSellBid->setCommission($sellBid->getCommission());
            $newSellBid->setPrice($sellBid->getPrice());
            $newSellBid->setSum($newSellBid->getQuantity() * $newSellBid->getPrice());
            $newSellBid->setDate($date);
            $newSellBid->setTypeBalance($sellBid->getTypeBalance());
            $this->em->persist($newSellBid);

            $sellWallet->setSum($sellWallet->getSum() + $newSellBid->getSum());


            // Save Buy Bid
            $buyBid->setStatus(true);
            $sum = $buyBid->getPrice() * $buyBid->getQuantity();
            $buyBid->setDate($date);
            $buyBid->setSum($sum);
            $this->em->persist($buyBid);

            $userCurrency->setSum($userCurrency->getSum() + $buyBid->getQuantity());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($newSellBid);
            $trade->setBuyBid($buyBid);
            $trade->setType(false);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $sum, 4);
        } elseif ($buyBid->getQuantity() > $sellBid->getQuantity()) {
            // Change Sell Bid
            $buyBid->setQuantity($buyBid->getQuantity() - $sellBid->getQuantity());
            $buyBid->setSum($buyBid->getQuantity() * $buyBid->getPrice());

            $sellBid->setStatus(true);

            $sellWallet->setSum($sellWallet->getSum() + $sellBid->getSum());

            // Create new BuyBid
            $newBuyBid = new Bid();
            $newBuyBid->setUser($user);
            $newBuyBid->setQuantity($sellBid->getQuantity());
            $newBuyBid->setStatus(true);
            $newBuyBid->setType(false);
            $newBuyBid->setCommission($buyBid->getCommission());
            $newBuyBid->setPrice($buyBid->getPrice());
            $newBuyBid->setSum($newBuyBid->getQuantity() * $newBuyBid->getPrice());
            $newBuyBid->setDate($date);
            $typeBalance = $this->em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                'name'  => 'M',
            ));
            $newBuyBid->setTypeBalance($typeBalance);
            $this->em->persist($newBuyBid);

            $userCurrency->setSum($userCurrency->getSum() + $newBuyBid->getQuantity());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($sellBid);
            $trade->setBuyBid($newBuyBid);
            $trade->setType(false);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $newBuyBid->getSum(), 4);
        } elseif ($buyBid->getQuantity() == $sellBid->getQuantity()) {
            // Save Buy Bid
            $buyBid->setStatus(true);
            $sum = $buyBid->getPrice() * $buyBid->getQuantity();
            $buyBid->setDate($date);
            $buyBid->setSum($sum);
            $this->em->persist($buyBid);

            $userCurrency->setSum($userCurrency->getSum() + $buyBid->getQuantity());

            // Change Sell Bid
            $sellBid->setStatus(true);
            $sellWallet->setSum($sellWallet->getSum() + $sellBid->getSum());

            // Create Trade
            $trade  = new Trade();
            $trade->setSellBid($sellBid);
            $trade->setBuyBid($buyBid);
            $trade->setType(false);
            $trade->setDate($date);
            $this->em->persist($trade);

            $this->saveTransaction($this->em, $user, $sum, 4);
        }

        $this->em->flush();
    }

    /**
     * @param EntityManager $em
     * @param User          $user
     * @param float         $sum
     * @param int           $type
     */
    protected function saveTransaction(EntityManager $em, User $user, $sum, $type)
    {
        // Save Transaction
        $mainType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
            'name'  => 'M',
        ));
        $mainWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
            'user'  => $user,
            'type'  => $mainType,
        ));
        $mainAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
            'user'  => $user,
            'type'  => $mainType,
        ));

        $bonusType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
            'name'  => 'B',
        ));
        $bonusWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
            'user'  => $user,
            'type'  => $bonusType,
        ));
        $bonusAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
            'user'  => $user,
            'type'  => $bonusType,
        ));

        $event = new TransactionEvent($user, $sum, $mainWallet->getSum(), $bonusWallet->getSum(), $mainAccount->getSum(), $bonusAccount->getSum(), $type);
        $this->dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);
    }
}
