<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/12/15
 * Time: 5:18 PM
 */

namespace ExchangeBundle\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ExchangeBundle\Entity\Statistic;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserWallet;

/**
 * Class LoadStatisticData
 * @package ExchangeBundle\DataFixtures\ORM
 */
class LoadStatisticData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();
        $date->modify('-10000 min');

        for ($i = 0; $i < 100; $i++) {
            $statistic = new Statistic();
            $statistic->setDate($date->modify('+30 min'));
            $statistic->setOpen(rand(10045, 19923)/100);
            $statistic->setHigh(rand(10045, 19923)/100);
            $statistic->setLow(rand(10045, 19923)/100);
            $statistic->setClose(rand(10045, 19923)/100);
            $manager->persist($statistic);
            $manager->flush($statistic);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
