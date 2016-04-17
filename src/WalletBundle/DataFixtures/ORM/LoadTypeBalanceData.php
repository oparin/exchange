<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 11:31 AM
 */

namespace WalletBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WalletBundle\Entity\TypeBalance;

/**
 * Class LoadTypeBalanceData
 * @package WalletBundle
 */
class LoadTypeBalanceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $type = new TypeBalance();
        $type->setName('M');
        $manager->persist($type);
        $this->addReference('type_m', $type);

        $type = new TypeBalance();
        $type->setName('A');
        $manager->persist($type);
        $this->addReference('type_a', $type);

        $type = new TypeBalance();
        $type->setName('B');
        $manager->persist($type);
        $this->addReference('type_b', $type);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
