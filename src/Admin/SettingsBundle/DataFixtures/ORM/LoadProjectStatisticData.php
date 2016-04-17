<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/2/15
 * Time: 12:28 PM
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\ProjectStatistic;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadProjectStatisticData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadProjectStatisticData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 13; $i > -1; $i--) {
            $statistic = new ProjectStatistic();
            $date = new \DateTime();
            $statistic->setDate($date->modify('-'.$i.' day'));
            $statistic->setMaxCourse(100);
//            $statistic->setAmountTransactions(rand(20, 1000));
//            $statistic->setTransactionsOnExchange(rand(20, 1000));
//            $statistic->setNumberTransactions(rand(20, 1000));
//            $statistic->setNumberMembers(rand(20, 1000));
//            $statistic->setNewMembers(rand(20, 1000));
//            $statistic->setAverageTime(rand(5, 25));
//            $statistic->setAverageRate(rand(1.1, 5));
//            $statistic->setAverageAmount(rand(20, 1000));
            $manager->persist($statistic);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
