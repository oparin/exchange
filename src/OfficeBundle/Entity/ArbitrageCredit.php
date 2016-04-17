<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 3:16 PM
 */

namespace OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use StatisticBundle\Entity\ArbitrageFineStatistic;
use StatisticBundle\Entity\ArbitrageProlongationStatistic;
use UserBundle\Entity\User;

/**
 * Class ArbitrageCredit
 * @package OfficeBundle
 *
 * @ORM\Entity
 * @ORM\Table(name="arbitrage_credit")
 */
class ArbitrageCredit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="arbitrageCredit")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum;

    /**
     * @ORM\Column(type="integer")
     */
    protected $multiplier;

    /**
     * @ORM\Column(type="integer")
     */
    protected $days;

    /**
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $percent;

    /**
     * @ORM\Column(type="datetime", name="date_start")
     */
    protected $dateStart;

    /**
     * @ORM\Column(type="decimal", scale=2, name="return_sum")
     */
    protected $returnSum;

    /**
     * @ORM\Column(type="datetime", name="date_end")
     */
    protected $dateEnd;

    /**
     * 0 - wait
     * 1 - given
     * 2 - not given
     *
     * @ORM\Column(type="smallint")
     */
    protected $status = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $prolongation = false;

    /**
     * @ORM\Column(type="datetime", name="fine_date", nullable=true)
     */
    protected $fineDate;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\ArbitrageFineStatistic", mappedBy="arbitrage", cascade={"persist", "remove"})
     */
    protected $fineStatistic;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\ArbitrageProlongationStatistic", mappedBy="arbitrage", cascade={"persist", "remove"})
     */
    protected $prolongationStatistic;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fineStatistic = new \Doctrine\Common\Collections\ArrayCollection();
        $this->prolongationStatistic = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set sum
     *
     * @param string $sum
     *
     * @return ArbitrageCredit
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set multiplier
     *
     * @param integer $multiplier
     *
     * @return ArbitrageCredit
     */
    public function setMultiplier($multiplier)
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    /**
     * Get multiplier
     *
     * @return integer
     */
    public function getMultiplier()
    {
        return $this->multiplier;
    }

    /**
     * Set days
     *
     * @param integer $days
     *
     * @return ArbitrageCredit
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return integer
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set percent
     *
     * @param string $percent
     *
     * @return ArbitrageCredit
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return ArbitrageCredit
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set returnSum
     *
     * @param string $returnSum
     *
     * @return ArbitrageCredit
     */
    public function setReturnSum($returnSum)
    {
        $this->returnSum = $returnSum;

        return $this;
    }

    /**
     * Get returnSum
     *
     * @return string
     */
    public function getReturnSum()
    {
        return $this->returnSum;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return ArbitrageCredit
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return ArbitrageCredit
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set prolongation
     *
     * @param boolean $prolongation
     *
     * @return ArbitrageCredit
     */
    public function setProlongation($prolongation)
    {
        $this->prolongation = $prolongation;

        return $this;
    }

    /**
     * Get prolongation
     *
     * @return boolean
     */
    public function getProlongation()
    {
        return $this->prolongation;
    }

    /**
     * Set fineDate
     *
     * @param \DateTime $fineDate
     *
     * @return ArbitrageCredit
     */
    public function setFineDate($fineDate)
    {
        $this->fineDate = $fineDate;

        return $this;
    }

    /**
     * Get fineDate
     *
     * @return \DateTime
     */
    public function getFineDate()
    {
        return $this->fineDate;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return ArbitrageCredit
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add fineStatistic
     *
     * @param \StatisticBundle\Entity\ArbitrageFineStatistic $fineStatistic
     *
     * @return ArbitrageCredit
     */
    public function addFineStatistic(ArbitrageFineStatistic $fineStatistic)
    {
        $this->fineStatistic[] = $fineStatistic;

        return $this;
    }

    /**
     * Remove fineStatistic
     *
     * @param \StatisticBundle\Entity\ArbitrageFineStatistic $fineStatistic
     */
    public function removeFineStatistic(ArbitrageFineStatistic $fineStatistic)
    {
        $this->fineStatistic->removeElement($fineStatistic);
    }

    /**
     * Get fineStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFineStatistic()
    {
        return $this->fineStatistic;
    }

    /**
     * Add prolongationStatistic
     *
     * @param \StatisticBundle\Entity\ArbitrageProlongationStatistic $prolongationStatistic
     *
     * @return ArbitrageCredit
     */
    public function addProlongationStatistic(ArbitrageProlongationStatistic $prolongationStatistic)
    {
        $this->prolongationStatistic[] = $prolongationStatistic;

        return $this;
    }

    /**
     * Remove prolongationStatistic
     *
     * @param \StatisticBundle\Entity\ArbitrageProlongationStatistic $prolongationStatistic
     */
    public function removeProlongationStatistic(ArbitrageProlongationStatistic $prolongationStatistic)
    {
        $this->prolongationStatistic->removeElement($prolongationStatistic);
    }

    /**
     * Get prolongationStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProlongationStatistic()
    {
        return $this->prolongationStatistic;
    }
}
