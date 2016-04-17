<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/13/15
 * Time: 12:50 PM
 */

namespace UserBundle\Entity;

use Admin\SettingsBundle\Entity\MemberStatus;
use ExchangeBundle\Entity\Bid;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Binary;
use OfficeBundle\Entity\ArbitrageCredit;
use StatisticBundle\Entity\MiningHistory;
use StatisticBundle\Entity\MiningStatistic;
use StatisticBundle\Entity\PointsStatistic;
use StatisticBundle\Entity\SponsorBonusStatistic;
use StatisticBundle\Entity\TransactionStatistic;
use StatisticBundle\Entity\WalletStatistic;
use TicketBundle\Entity\ReplySupportTicket;
use TicketBundle\Entity\SupportTicket;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCurrency;
use WalletBundle\Entity\UserWallet;
use WalletBundle\Entity\UserWithdraw;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $sponsor;

    /**
     * @ORM\Column(type="string", name="register_ip", nullable=true)
     */
    protected $registerIp;

    /**
     * @ORM\Column(type="string", name="last_ip", nullable=true)
     */
    protected $lastIp;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserAccount", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWallet", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $wallets;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserCurrency", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $currency;

    /**
     * @ORM\Column(type="datetime", name="registration_date")
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rating = 0;

    /**
     * @ORM\Column(type="decimal", scale=2, name="registration_bonus")
     */
    protected $registrationBonus = 0.00;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\SettingsBundle\Entity\MemberStatus", inversedBy="users")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="TicketBundle\Entity\SupportTicket", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $supportTickets;

    /**
     * @ORM\OneToMany(targetEntity="TicketBundle\Entity\ReplySupportTicket", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $replySupportTickets;

    /**
     * @ORM\OneToMany(targetEntity="ExchangeBundle\Entity\Bid", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $bids;

    /**
     * @ORM\OneToOne(targetEntity="MarketingBundle\Entity\Binary", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $binary;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\PointsStatistic", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $statisticPoints;

    /**
     * @ORM\OneToMany(targetEntity="OfficeBundle\Entity\ArbitrageCredit", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $arbitrageCredit;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\WalletStatistic", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $walletStatistic;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWithdraw", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $withdraw;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\TransactionStatistic", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $transactionStatistic;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\SponsorBonusStatistic", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $sponsorBonus;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights")
     */
    protected $miningRights = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights_in_work")
     */
    protected $miningRightsInWork = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2, name="pool_wallet")
     */
    protected $poolWallet = 0.00;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\MiningStatistic", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $miningStatistic;

    /**
     * @ORM\Column(type="integer", name="count_multiply")
     */
    protected $countMultiply = 0;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\MiningHistory", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $miningHistory;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->wallets  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->currency = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set registerIp
     *
     * @param string $registerIp
     *
     * @return User
     */
    public function setRegisterIp($registerIp)
    {
        $this->registerIp = $registerIp;

        return $this;
    }

    /**
     * Get registerIp
     *
     * @return string
     */
    public function getRegisterIp()
    {
        return $this->registerIp;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     *
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set sponsor
     *
     * @param \UserBundle\Entity\User $sponsor
     *
     * @return User
     */
    public function setSponsor(User $sponsor = null)
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * Get sponsor
     *
     * @return \UserBundle\Entity\User
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * Add account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     *
     * @return User
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
     * @return User
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
     * Set registrationDate
     *
     * @param \dateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate(\dateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \dateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return User
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set registrationBonus
     *
     * @param string $registrationBonus
     *
     * @return User
     */
    public function setRegistrationBonus($registrationBonus)
    {
        $this->registrationBonus = $registrationBonus;

        return $this;
    }

    /**
     * Get registrationBonus
     *
     * @return string
     */
    public function getRegistrationBonus()
    {
        return $this->registrationBonus;
    }

    /**
     * Set status
     *
     * @param \Admin\SettingsBundle\Entity\MemberStatus $status
     *
     * @return User
     */
    public function setStatus(MemberStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Admin\SettingsBundle\Entity\MemberStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add supportTicket
     *
     * @param \TicketBundle\Entity\SupportTicket $supportTicket
     *
     * @return User
     */
    public function addSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets[] = $supportTicket;

        return $this;
    }

    /**
     * Remove supportTicket
     *
     * @param \TicketBundle\Entity\SupportTicket $supportTicket
     */
    public function removeSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets->removeElement($supportTicket);
    }

    /**
     * Get supportTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportTickets()
    {
        return $this->supportTickets;
    }

    /**
     * Add replySupportTicket
     *
     * @param \TicketBundle\Entity\ReplySupportTicket $replySupportTicket
     *
     * @return User
     */
    public function addReplySupportTicket(ReplySupportTicket $replySupportTicket)
    {
        $this->replySupportTickets[] = $replySupportTicket;

        return $this;
    }

    /**
     * Remove replySupportTicket
     *
     * @param \TicketBundle\Entity\ReplySupportTicket $replySupportTicket
     */
    public function removeReplySupportTicket(ReplySupportTicket $replySupportTicket)
    {
        $this->replySupportTickets->removeElement($replySupportTicket);
    }

    /**
     * Get replySupportTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplySupportTickets()
    {
        return $this->replySupportTickets;
    }

    /**
     * Add bid
     *
     * @param \ExchangeBundle\Entity\Bid $bid
     *
     * @return User
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

    /**
     * Add currency
     *
     * @param \WalletBundle\Entity\UserCurrency $currency
     *
     * @return User
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
     * Set binary
     *
     * @param \MarketingBundle\Entity\Binary $binary
     *
     * @return User
     */
    public function setBinary(Binary $binary = null)
    {
        $this->binary = $binary;

        return $this;
    }

    /**
     * Get binary
     *
     * @return \MarketingBundle\Entity\Binary
     */
    public function getBinary()
    {
        return $this->binary;
    }

    /**
     * Add statisticPoint
     *
     * @param \StatisticBundle\Entity\PointsStatistic $statisticPoint
     *
     * @return User
     */
    public function addStatisticPoint(PointsStatistic $statisticPoint)
    {
        $this->statisticPoints[] = $statisticPoint;

        return $this;
    }

    /**
     * Remove statisticPoint
     *
     * @param \StatisticBundle\Entity\PointsStatistic $statisticPoint
     */
    public function removeStatisticPoint(PointsStatistic $statisticPoint)
    {
        $this->statisticPoints->removeElement($statisticPoint);
    }

    /**
     * Get statisticPoints
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatisticPoints()
    {
        return $this->statisticPoints;
    }

    /**
     * Add arbitrageCredit
     *
     * @param \OfficeBundle\Entity\ArbitrageCredit $arbitrageCredit
     *
     * @return User
     */
    public function addArbitrageCredit(ArbitrageCredit $arbitrageCredit)
    {
        $this->arbitrageCredit[] = $arbitrageCredit;

        return $this;
    }

    /**
     * Remove arbitrageCredit
     *
     * @param \OfficeBundle\Entity\ArbitrageCredit $arbitrageCredit
     */
    public function removeArbitrageCredit(ArbitrageCredit $arbitrageCredit)
    {
        $this->arbitrageCredit->removeElement($arbitrageCredit);
    }

    /**
     * Get arbitrageCredit
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArbitrageCredit()
    {
        return $this->arbitrageCredit;
    }

    /**
     * Add walletStatistic
     *
     * @param \StatisticBundle\Entity\WalletStatistic $walletStatistic
     *
     * @return User
     */
    public function addWalletStatistic(\StatisticBundle\Entity\WalletStatistic $walletStatistic)
    {
        $this->walletStatistic[] = $walletStatistic;

        return $this;
    }

    /**
     * Remove walletStatistic
     *
     * @param \StatisticBundle\Entity\WalletStatistic $walletStatistic
     */
    public function removeWalletStatistic(WalletStatistic $walletStatistic)
    {
        $this->walletStatistic->removeElement($walletStatistic);
    }

    /**
     * Get walletStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWalletStatistic()
    {
        return $this->walletStatistic;
    }

    /**
     * Add withdraw
     *
     * @param \WalletBundle\Entity\UserWithdraw $withdraw
     *
     * @return User
     */
    public function addWithdraw(UserWithdraw $withdraw)
    {
        $this->withdraw[] = $withdraw;

        return $this;
    }

    /**
     * Remove withdraw
     *
     * @param \WalletBundle\Entity\UserWithdraw $withdraw
     */
    public function removeWithdraw(UserWithdraw $withdraw)
    {
        $this->withdraw->removeElement($withdraw);
    }

    /**
     * Get withdraw
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWithdraw()
    {
        return $this->withdraw;
    }

    /**
     * Add transactionStatistic
     *
     * @param \StatisticBundle\Entity\TransactionStatistic $transactionStatistic
     *
     * @return User
     */
    public function addTransactionStatistic(TransactionStatistic $transactionStatistic)
    {
        $this->transactionStatistic[] = $transactionStatistic;

        return $this;
    }

    /**
     * Remove transactionStatistic
     *
     * @param \StatisticBundle\Entity\TransactionStatistic $transactionStatistic
     */
    public function removeTransactionStatistic(TransactionStatistic $transactionStatistic)
    {
        $this->transactionStatistic->removeElement($transactionStatistic);
    }

    /**
     * Get transactionStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactionStatistic()
    {
        return $this->transactionStatistic;
    }

    /**
     * Add sponsorBonus
     *
     * @param \StatisticBundle\Entity\SponsorBonusStatistic $sponsorBonus
     *
     * @return User
     */
    public function addSponsorBonus(SponsorBonusStatistic $sponsorBonus)
    {
        $this->sponsorBonus[] = $sponsorBonus;

        return $this;
    }

    /**
     * Remove sponsorBonus
     *
     * @param \StatisticBundle\Entity\SponsorBonusStatistic $sponsorBonus
     */
    public function removeSponsorBonus(SponsorBonusStatistic $sponsorBonus)
    {
        $this->sponsorBonus->removeElement($sponsorBonus);
    }

    /**
     * Get sponsorBonus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSponsorBonus()
    {
        return $this->sponsorBonus;
    }

    /**
     * Set miningRights
     *
     * @param string $miningRights
     *
     * @return User
     */
    public function setMiningRights($miningRights)
    {
        $this->miningRights = $miningRights;

        return $this;
    }

    /**
     * Get miningRights
     *
     * @return string
     */
    public function getMiningRights()
    {
        return $this->miningRights;
    }

    /**
     * Set miningRightsInWork
     *
     * @param string $miningRightsInWork
     *
     * @return User
     */
    public function setMiningRightsInWork($miningRightsInWork)
    {
        $this->miningRightsInWork = $miningRightsInWork;

        return $this;
    }

    /**
     * Get miningRightsInWork
     *
     * @return string
     */
    public function getMiningRightsInWork()
    {
        return $this->miningRightsInWork;
    }

    /**
     * Set poolWallet
     *
     * @param string $poolWallet
     *
     * @return User
     */
    public function setPoolWallet($poolWallet)
    {
        $this->poolWallet = $poolWallet;

        return $this;
    }

    /**
     * Get poolWallet
     *
     * @return string
     */
    public function getPoolWallet()
    {
        return $this->poolWallet;
    }

    /**
     * Add miningStatistic
     *
     * @param \StatisticBundle\Entity\MiningStatistic $miningStatistic
     *
     * @return User
     */
    public function addMiningStatistic(MiningStatistic $miningStatistic)
    {
        $this->miningStatistic[] = $miningStatistic;

        return $this;
    }

    /**
     * Remove miningStatistic
     *
     * @param \StatisticBundle\Entity\MiningStatistic $miningStatistic
     */
    public function removeMiningStatistic(MiningStatistic $miningStatistic)
    {
        $this->miningStatistic->removeElement($miningStatistic);
    }

    /**
     * Get miningStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMiningStatistic()
    {
        return $this->miningStatistic;
    }

    /**
     * Set countMultiply
     *
     * @param integer $countMultiply
     *
     * @return User
     */
    public function setCountMultiply($countMultiply)
    {
        $this->countMultiply = $countMultiply;

        return $this;
    }

    /**
     * Get countMultiply
     *
     * @return integer
     */
    public function getCountMultiply()
    {
        return $this->countMultiply;
    }

    /**
     * Add miningHistory
     *
     * @param \StatisticBundle\Entity\MiningHistory $miningHistory
     *
     * @return User
     */
    public function addMiningHistory(MiningHistory $miningHistory)
    {
        $this->miningHistory[] = $miningHistory;

        return $this;
    }

    /**
     * Remove miningHistory
     *
     * @param \StatisticBundle\Entity\MiningHistory $miningHistory
     */
    public function removeMiningHistory(MiningHistory $miningHistory)
    {
        $this->miningHistory->removeElement($miningHistory);
    }

    /**
     * Get miningHistory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMiningHistory()
    {
        return $this->miningHistory;
    }
}
