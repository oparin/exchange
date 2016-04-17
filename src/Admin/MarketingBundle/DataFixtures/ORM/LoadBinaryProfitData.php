<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 11:24 AM
 */

namespace Admin\MarketingBundle\DataFixtures\ORM;

use Admin\MarketingBundle\Entity\BinaryProfit;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadBinaryProfitData
 * @package Admin\MarketingBundle\DataFixtures\ORM
 */
class LoadBinaryProfitData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('silver'));
        $profit->setStatusTo($this->getReference('silver'));
        $profit->setPoints(50);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('silver'));
        $profit->setStatusTo($this->getReference('gold'));
        $profit->setPoints(199);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('silver'));
        $profit->setStatusTo($this->getReference('diamond'));
        $profit->setPoints(499);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('silver'));
        $profit->setStatusTo($this->getReference('ethereum'));
        $profit->setPoints(999);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('silver'));
        $profit->setStatusTo($this->getReference('ethereum_pro'));
        $profit->setPoints(1999);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('gold'));
        $profit->setStatusTo($this->getReference('silver'));
        $profit->setPoints(50);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('gold'));
        $profit->setStatusTo($this->getReference('gold'));
        $profit->setPoints(199);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('gold'));
        $profit->setStatusTo($this->getReference('diamond'));
        $profit->setPoints(499);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('gold'));
        $profit->setStatusTo($this->getReference('ethereum'));
        $profit->setPoints(999);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('gold'));
        $profit->setStatusTo($this->getReference('ethereum_pro'));
        $profit->setPoints(1999);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('diamond'));
        $profit->setStatusTo($this->getReference('silver'));
        $profit->setPoints(50);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('diamond'));
        $profit->setStatusTo($this->getReference('gold'));
        $profit->setPoints(210);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('diamond'));
        $profit->setStatusTo($this->getReference('diamond'));
        $profit->setPoints(525);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('diamond'));
        $profit->setStatusTo($this->getReference('ethereum'));
        $profit->setPoints(1050);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('diamond'));
        $profit->setStatusTo($this->getReference('ethereum_pro'));
        $profit->setPoints(2100);
        $manager->persist($profit);


        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum'));
        $profit->setStatusTo($this->getReference('silver'));
        $profit->setPoints(50);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum'));
        $profit->setStatusTo($this->getReference('gold'));
        $profit->setPoints(215);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum'));
        $profit->setStatusTo($this->getReference('diamond'));
        $profit->setPoints(550);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum'));
        $profit->setStatusTo($this->getReference('ethereum'));
        $profit->setPoints(1100);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum'));
        $profit->setStatusTo($this->getReference('ethereum_pro'));
        $profit->setPoints(2200);
        $manager->persist($profit);


        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum_pro'));
        $profit->setStatusTo($this->getReference('silver'));
        $profit->setPoints(55);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum_pro'));
        $profit->setStatusTo($this->getReference('gold'));
        $profit->setPoints(220);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum_pro'));
        $profit->setStatusTo($this->getReference('diamond'));
        $profit->setPoints(600);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum_pro'));
        $profit->setStatusTo($this->getReference('ethereum'));
        $profit->setPoints(1200);
        $manager->persist($profit);

        $profit = new BinaryProfit();
        $profit->setStatusFrom($this->getReference('ethereum_pro'));
        $profit->setStatusTo($this->getReference('ethereum_pro'));
        $profit->setPoints(2500);
        $manager->persist($profit);

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
