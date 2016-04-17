<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 05.04.16
 * Time: 15:30
 */

namespace Admin\MiningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rate
 * @package Admin\MiningBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mining_rates")
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $buy = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sell = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $convertat = 0.00;

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
     * Set buy
     *
     * @param string $buy
     *
     * @return Rate
     */
    public function setBuy($buy)
    {
        $this->buy = $buy;

        return $this;
    }

    /**
     * Get buy
     *
     * @return string
     */
    public function getBuy()
    {
        return $this->buy;
    }

    /**
     * Set sell
     *
     * @param string $sell
     *
     * @return Rate
     */
    public function setSell($sell)
    {
        $this->sell = $sell;

        return $this;
    }

    /**
     * Get sell
     *
     * @return string
     */
    public function getSell()
    {
        return $this->sell;
    }

    /**
     * Set convertat
     *
     * @param string $convertat
     *
     * @return Rate
     */
    public function setConvertat($convertat)
    {
        $this->convertat = $convertat;

        return $this;
    }

    /**
     * Get convertat
     *
     * @return string
     */
    public function getConvertat()
    {
        return $this->convertat;
    }
}
