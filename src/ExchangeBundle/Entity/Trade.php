<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/16/15
 * Time: 12:46 PM
 */

namespace ExchangeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Trade
 * @package ExchangeBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="trades")
 */
class Trade
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Bid")
     * @ORM\JoinColumn(name="sell_bid_id", referencedColumnName="id")
     */
    protected $sellBid;

    /**
     * @ORM\ManyToOne(targetEntity="Bid")
     * @ORM\JoinColumn(name="buy_bid_id", referencedColumnName="id")
     */
    protected $buyBid;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * 0 - Buy
     * 1 - Sell
     * @ORM\Column(type="boolean")
     */
    protected $type;

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
     * @return Trade
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
     * Set sellBid
     *
     * @param \ExchangeBundle\Entity\Bid $sellBid
     *
     * @return Trade
     */
    public function setSellBid(Bid $sellBid = null)
    {
        $this->sellBid = $sellBid;

        return $this;
    }

    /**
     * Get sellBid
     *
     * @return \ExchangeBundle\Entity\Bid
     */
    public function getSellBid()
    {
        return $this->sellBid;
    }

    /**
     * Set buyBid
     *
     * @param \ExchangeBundle\Entity\Bid $buyBid
     *
     * @return Trade
     */
    public function setBuyBid(Bid $buyBid = null)
    {
        $this->buyBid = $buyBid;

        return $this;
    }

    /**
     * Get buyBid
     *
     * @return \ExchangeBundle\Entity\Bid
     */
    public function getBuyBid()
    {
        return $this->buyBid;
    }

    /**
     * Set type
     *
     * @param boolean $type
     *
     * @return Trade
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }
}
