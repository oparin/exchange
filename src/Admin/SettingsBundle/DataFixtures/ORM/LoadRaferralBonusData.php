<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.02.16
 * Time: 9:39
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\ReferralBonus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadRaferralBonusData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadRaferralBonusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('silver'));
        $bonus->setStatusTo($this->getReference('silver'));
        $bonus->setBonus(8);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('silver'));
        $bonus->setStatusTo($this->getReference('gold'));
        $bonus->setBonus(10);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('silver'));
        $bonus->setStatusTo($this->getReference('diamond'));
        $bonus->setBonus(12);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('silver'));
        $bonus->setStatusTo($this->getReference('ethereum'));
        $bonus->setBonus(15);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('silver'));
        $bonus->setStatusTo($this->getReference('ethereum_pro'));
        $bonus->setBonus(20);
        $manager->persist($bonus);


        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('gold'));
        $bonus->setStatusTo($this->getReference('silver'));
        $bonus->setBonus(8);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('gold'));
        $bonus->setStatusTo($this->getReference('gold'));
        $bonus->setBonus(10);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('gold'));
        $bonus->setStatusTo($this->getReference('diamond'));
        $bonus->setBonus(12);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('gold'));
        $bonus->setStatusTo($this->getReference('ethereum'));
        $bonus->setBonus(15);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('gold'));
        $bonus->setStatusTo($this->getReference('ethereum_pro'));
        $bonus->setBonus(20);
        $manager->persist($bonus);


        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('diamond'));
        $bonus->setStatusTo($this->getReference('silver'));
        $bonus->setBonus(8);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('diamond'));
        $bonus->setStatusTo($this->getReference('gold'));
        $bonus->setBonus(10);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('diamond'));
        $bonus->setStatusTo($this->getReference('diamond'));
        $bonus->setBonus(12);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('diamond'));
        $bonus->setStatusTo($this->getReference('ethereum'));
        $bonus->setBonus(15);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('diamond'));
        $bonus->setStatusTo($this->getReference('ethereum_pro'));
        $bonus->setBonus(20);
        $manager->persist($bonus);


        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum'));
        $bonus->setStatusTo($this->getReference('silver'));
        $bonus->setBonus(8);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum'));
        $bonus->setStatusTo($this->getReference('gold'));
        $bonus->setBonus(10);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum'));
        $bonus->setStatusTo($this->getReference('diamond'));
        $bonus->setBonus(12);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum'));
        $bonus->setStatusTo($this->getReference('ethereum'));
        $bonus->setBonus(15);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum'));
        $bonus->setStatusTo($this->getReference('ethereum_pro'));
        $bonus->setBonus(20);
        $manager->persist($bonus);


        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum_pro'));
        $bonus->setStatusTo($this->getReference('silver'));
        $bonus->setBonus(8);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum_pro'));
        $bonus->setStatusTo($this->getReference('gold'));
        $bonus->setBonus(10);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum_pro'));
        $bonus->setStatusTo($this->getReference('diamond'));
        $bonus->setBonus(12);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum_pro'));
        $bonus->setStatusTo($this->getReference('ethereum'));
        $bonus->setBonus(15);
        $manager->persist($bonus);

        $bonus = new ReferralBonus();
        $bonus->setStatusFrom($this->getReference('ethereum_pro'));
        $bonus->setStatusTo($this->getReference('ethereum_pro'));
        $bonus->setBonus(20);
        $manager->persist($bonus);

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
