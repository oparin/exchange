<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/17/15
 * Time: 2:19 PM
 */

namespace ExchangeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Statistic
 * @package ExchangeBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="statistic_trades")
 */
class Statistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="string")
     */
    protected $open;

    /**
     * @ORM\Column(type="string")
     */
    protected $high;

    /**
     * @ORM\Column(type="string")
     */
    protected $low;

    /**
     * @ORM\Column(type="string")
     */
    protected $close;

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
     * @return Statistic
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
     * Set open
     *
     * @param string $open
     *
     * @return Statistic
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return string
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set high
     *
     * @param string $high
     *
     * @return Statistic
     */
    public function setHigh($high)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * Get high
     *
     * @return string
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set low
     *
     * @param string $low
     *
     * @return Statistic
     */
    public function setLow($low)
    {
        $this->low = $low;

        return $this;
    }

    /**
     * Get low
     *
     * @return string
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Set close
     *
     * @param string $close
     *
     * @return Statistic
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }

    /**
     * Get close
     *
     * @return string
     */
    public function getClose()
    {
        return $this->close;
    }
}
