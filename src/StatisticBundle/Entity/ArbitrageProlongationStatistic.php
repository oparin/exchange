<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 3:07 PM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OfficeBundle\Entity\ArbitrageCredit;

/**
 * Class ArbitrageProlongationStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="arbitrage_prolongation_statistic")
 */
class ArbitrageProlongationStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OfficeBundle\Entity\ArbitrageCredit", inversedBy="prolongationStatistic", cascade={"persist"})
     * @ORM\JoinColumn(name="arbitrage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $arbitrage;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="datetime", name="old_date")
     */
    protected $oldDate;

    /**
     * @ORM\Column(type="datetime", name="new_date", nullable=true)
     */
    protected $newDate;

    /**
     * @ORM\Column(type="decimal", scale=2, name="old_sum")
     */
    protected $oldSum;

    /**
     * @ORM\Column(type="decimal", scale=2, name="new_sum", nullable=true)
     */
    protected $newSum;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set oldDate
     *
     * @param \DateTime $oldDate
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setOldDate($oldDate)
    {
        $this->oldDate = $oldDate;

        return $this;
    }

    /**
     * Get oldDate
     *
     * @return \DateTime
     */
    public function getOldDate()
    {
        return $this->oldDate;
    }

    /**
     * Set newDate
     *
     * @param \DateTime $newDate
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setNewDate($newDate)
    {
        $this->newDate = $newDate;

        return $this;
    }

    /**
     * Get newDate
     *
     * @return \DateTime
     */
    public function getNewDate()
    {
        return $this->newDate;
    }

    /**
     * Set oldSum
     *
     * @param string $oldSum
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setOldSum($oldSum)
    {
        $this->oldSum = $oldSum;

        return $this;
    }

    /**
     * Get oldSum
     *
     * @return string
     */
    public function getOldSum()
    {
        return $this->oldSum;
    }

    /**
     * Set newSum
     *
     * @param string $newSum
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setNewSum($newSum)
    {
        $this->newSum = $newSum;

        return $this;
    }

    /**
     * Get newSum
     *
     * @return string
     */
    public function getNewSum()
    {
        return $this->newSum;
    }

    /**
     * Set arbitrage
     *
     * @param \OfficeBundle\Entity\ArbitrageCredit $arbitrage
     *
     * @return ArbitrageProlongationStatistic
     */
    public function setArbitrage(ArbitrageCredit $arbitrage = null)
    {
        $this->arbitrage = $arbitrage;

        return $this;
    }

    /**
     * Get arbitrage
     *
     * @return \OfficeBundle\Entity\ArbitrageCredit
     */
    public function getArbitrage()
    {
        return $this->arbitrage;
    }
}
