<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 11:26 AM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ExchangeBundle\Entity\Bid;

/**
 * Class TypeBalance
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="type_balances")
 */
class TypeBalance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserAccount", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWallet", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $wallets;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserCurrency", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $currency;

    /**
     * @ORM\OneToMany(targetEntity="ExchangeBundle\Entity\Bid", mappedBy="typeBalance", cascade={"persist", "remove"})
     */
    protected $bids;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TypeBalance
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->wallets  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->currency = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bids     = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     *
     * @return TypeBalance
     */
    public function addAccount(UserAccount $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     */
    public function removeAccount(UserAccount $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add wallet
     *
     * @param \WalletBundle\Entity\UserWallet $wallet
     *
     * @return TypeBalance
     */
    public function addWallet(UserWallet $wallet)
    {
        $this->wallets[] = $wallet;

        return $this;
    }

    /**
     * Remove wallet
     *
     * @param \WalletBundle\Entity\UserWallet $wallet
     */
    public function removeWallet(UserWallet $wallet)
    {
        $this->wallets->removeElement($wallet);
    }

    /**
     * Get wallets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWallets()
    {
        return $this->wallets;
    }

    /**
     * Add currency
     *
     * @param \WalletBundle\Entity\UserCurrency $currency
     *
     * @return TypeBalance
     */
    public function addCurrency(UserCurrency $currency)
    {
        $this->currency[] = $currency;

        return $this;
    }

    /**
     * Remove currency
     *
     * @param \WalletBundle\Entity\UserCurrency $currency
     */
    public function removeCurrency(UserCurrency $currency)
    {
        $this->currency->removeElement($currency);
    }

    /**
     * Get currency
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Add bid
     *
     * @param \ExchangeBundle\Entity\Bid $bid
     *
     * @return TypeBalance
     */
    public function addBid(Bid $bid)
    {
        $this->bids[] = $bid;

        return $this;
    }

    /**
     * Remove bid
     *
     * @param \ExchangeBundle\Entity\Bid $bid
     */
    public function removeBid(Bid $bid)
    {
        $this->bids->removeElement($bid);
    }

    /**
     * Get bids
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBids()
    {
        return $this->bids;
    }
}
