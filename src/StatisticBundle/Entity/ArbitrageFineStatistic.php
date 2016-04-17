<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 3:05 PM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OfficeBundle\Entity\ArbitrageCredit;

/**
 * Class ArbitrageFineStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="arbitrage_fine_statistic")
 */
class ArbitrageFineStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OfficeBundle\Entity\ArbitrageCredit", inversedBy="fineStatistic", cascade={"persist"})
     * @ORM\JoinColumn(name="arbitrage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $arbitrage;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal", scale=2, name="return_sum")
     */
    protected $returnSum;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $fine;

    /**
     * @ORM\Column(type="decimal", scale=2, name="return_sum_new")
     */
    protected $returnSumNew;

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
     * @return ArbitrageFineStatistic
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
     * Set returnSum
     *
     * @param string $returnSum
     *
     * @return ArbitrageFineStatistic
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
     * Set fine
     *
     * @param string $fine
     *
     * @return ArbitrageFineStatistic
     */
    public function setFine($fine)
    {
        $this->fine = $fine;

        return $this;
    }

    /**
     * Get fine
     *
     * @return string
     */
    public function getFine()
    {
        return $this->fine;
    }

    /**
     * Set returnSumNew
     *
     * @param string $returnSumNew
     *
     * @return ArbitrageFineStatistic
     */
    public function setReturnSumNew($returnSumNew)
    {
        $this->returnSumNew = $returnSumNew;

        return $this;
    }

    /**
     * Get returnSumNew
     *
     * @return string
     */
    public function getReturnSumNew()
    {
        return $this->returnSumNew;
    }

    /**
     * Set arbitrage
     *
     * @param \OfficeBundle\Entity\ArbitrageCredit $arbitrage
     *
     * @return ArbitrageFineStatistic
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
