<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/15/16
 * Time: 3:46 PM
 */

namespace WalletBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WalletBundle\Entity\TypeWithdraw;

/**
 * Class LoadTypeWithdraw
 * @package WalletBundle\DataFixtures\ORM
 */
class LoadTypeWithdraw extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $type = new TypeWithdraw();
        $type->setName('Perfect Money');
        $manager->persist($type);
        $this->addReference('pm', $type);

        $type = new TypeWithdraw();
        $type->setName('Payeer');
        $manager->persist($type);
        $this->addReference('pr', $type);

        $type = new TypeWithdraw();
        $type->setName('Advanced Cash');
        $manager->persist($type);
        $this->addReference('ac', $type);

        $type = new TypeWithdraw();
        $type->setName('Ethereum');
        $manager->persist($type);
        $this->addReference('et', $type);

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
