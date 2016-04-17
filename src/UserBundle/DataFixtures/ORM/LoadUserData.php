<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/12/15
 * Time: 5:18 PM
 */

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MarketingBundle\Entity\Binary;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCurrency;
use WalletBundle\Entity\UserWallet;
use WalletBundle\Entity\UserWithdraw;

/**
 * Class LoadUserData
 * @package Admin\UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPlainPassword('user');
        $user->setEmail('user@user.com');
        $user->setEnabled(true);
        $user->setRegistrationDate(new \DateTime());
        $user->addRole('ROLE_USER');
        $manager->persist($user);

        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->getReference('type_m'));
        $manager->persist($account);

        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->getReference('type_a'));
        $manager->persist($account);

        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->getReference('type_b'));
        $manager->persist($account);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->getReference('type_m'));
        $manager->persist($wallet);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->getReference('type_a'));
        $manager->persist($wallet);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->getReference('type_b'));
        $manager->persist($wallet);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->getReference('type_m'));
        $manager->persist($currency);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->getReference('type_a'));
        $manager->persist($currency);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->getReference('type_b'));
        $manager->persist($currency);


        $binary = new Binary();
        $binary->setUser($user);
        $manager->persist($binary);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->getReference('pm'));
        $manager->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->getReference('pr'));
        $manager->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->getReference('ac'));
        $manager->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->getReference('et'));
        $manager->persist($withdraw);

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
