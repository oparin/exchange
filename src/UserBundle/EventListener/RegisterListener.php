<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 10:36 AM
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use UserBundle\Event\UserEvent;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCurrency;
use WalletBundle\Entity\UserWallet;
use WalletBundle\Entity\UserWithdraw;

/**
 * Class RegisterListener
 * @package UserBundle\EventListener
 */
class RegisterListener
{
    protected $em;
    protected $session;
    protected $request;

    /**
     * RegisterListener constructor.
     *
     * @param EntityManager $em
     * @param Session       $session
     */
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em       = $em;
        $this->session  = $session;
    }

    /**
     * @param UserEvent $event
     */
    public function registerUser(UserEvent $event)
    {
        /** @var $user User */
        $user = $event->getUser();

        $user->addRole('ROLE_USER');

//        /** @var $settings Settings */
//        $settings = $this->em->getRepository('MatrixAdminSettingsBundle:Settings')->find(1);
//        $user->setRegistrationBonus($settings->getRegistrationBonus());

        // Create wallet
        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(1));
        $this->em->persist($account);

        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(2));
        $this->em->persist($account);

        $account = new UserAccount();
        $account->setUser($user);
        $account->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(3));
        $settings = $this->em->getRepository('AdminSettingsBundle:Settings')->find(1);
        $account->setSum($settings->getRegistrationBonus());
        $user->setRegistrationBonus($settings->getRegistrationBonus());
        $this->em->persist($account);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(1));
        $this->em->persist($wallet);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(2));
        $this->em->persist($wallet);

        $wallet = new UserWallet();
        $wallet->setUser($user);
        $wallet->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(3));
        $this->em->persist($wallet);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(1));
        $this->em->persist($currency);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(2));
        $this->em->persist($currency);

        $currency = new UserCurrency();
        $currency->setUser($user);
        $currency->setType($this->em->getRepository('WalletBundle:TypeBalance')->find(3));
        $this->em->persist($currency);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->em->getRepository('WalletBundle:TypeWithdraw')->find(1));
        $this->em->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->em->getRepository('WalletBundle:TypeWithdraw')->find(2));
        $this->em->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->em->getRepository('WalletBundle:TypeWithdraw')->find(3));
        $this->em->persist($withdraw);

        $withdraw = new UserWithdraw();
        $withdraw->setUser($user);
        $withdraw->setType($this->em->getRepository('WalletBundle:TypeWithdraw')->find(4));
        $this->em->persist($withdraw);

        // Save IP
        $user->setRegisterIp($event->getIp());

        // Set Sponsor
        if ($this->session->get('referral')) {
            $sponsor = $this->em->getRepository('UserBundle:User')->findOneBy(array(
                'username' => $this->session->get('referral'),
            ));
            if ($sponsor) {
                $user->setSponsor($sponsor);
            }
        }



        $this->em->flush();
    }
}
