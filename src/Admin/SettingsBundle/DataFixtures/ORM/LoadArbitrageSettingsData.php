<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 2:38 PM
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\ArbitrageSettings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadArbitrageSettingsData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadArbitrageSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $settings = new ArbitrageSettings();
        $settings->setMultiplier(3);
        $settings->setArbitrageMaxSum(3000);
        $settings->setArbitrageFinePercent(1);
        $settings->setArbitrageProlongation(0.7);
        $settings->setCommission(0.5);
        $manager->persist($settings);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
