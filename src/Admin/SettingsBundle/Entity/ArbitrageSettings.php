<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 2:20 PM
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ArbitrageSettings
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="arbitrage_settings")
 */
class ArbitrageSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $multiplier;

    /**
     * @ORM\Column(type="decimal", scale=1, name="arbitrage_max_sum")
     */
    protected $arbitrageMaxSum;

    /**
     * @ORM\Column(type="decimal", scale=1, name="commission")
     */
    protected $commission;

    /**
     * @ORM\Column(type="decimal", scale=1, name="arbitrage_fine_percent")
     */
    protected $arbitrageFinePercent;

    /**
     * @ORM\Column(type="decimal", scale=2, name="arbitrage_prolongation")
     */
    protected $arbitrageProlongation;

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
     * Set multiplier
     *
     * @param integer $multiplier
     *
     * @return ArbitrageSettings
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
     * Set arbitrageMaxSum
     *
     * @param string $arbitrageMaxSum
     *
     * @return ArbitrageSettings
     */
    public function setArbitrageMaxSum($arbitrageMaxSum)
    {
        $this->arbitrageMaxSum = $arbitrageMaxSum;

        return $this;
    }

    /**
     * Get arbitrageMaxSum
     *
     * @return string
     */
    public function getArbitrageMaxSum()
    {
        return $this->arbitrageMaxSum;
    }

    /**
     * Set arbitrageFinePercent
     *
     * @param integer $arbitrageFinePercent
     *
     * @return ArbitrageSettings
     */
    public function setArbitrageFinePercent($arbitrageFinePercent)
    {
        $this->arbitrageFinePercent = $arbitrageFinePercent;

        return $this;
    }

    /**
     * Get arbitrageFinePercent
     *
     * @return integer
     */
    public function getArbitrageFinePercent()
    {
        return $this->arbitrageFinePercent;
    }

    /**
     * Set arbitrageProlongation
     *
     * @param string $arbitrageProlongation
     *
     * @return ArbitrageSettings
     */
    public function setArbitrageProlongation($arbitrageProlongation)
    {
        $this->arbitrageProlongation = $arbitrageProlongation;

        return $this;
    }

    /**
     * Get arbitrageProlongation
     *
     * @return string
     */
    public function getArbitrageProlongation()
    {
        return $this->arbitrageProlongation;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return ArbitrageSettings
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }
}
