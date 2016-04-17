<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 10:19 AM
 */

namespace Admin\MarketingBundle\Entity;

use Admin\SettingsBundle\Entity\MemberStatus;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BinaryProfit
 * @package Admin\MarketingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="binary_profit")
 */
class BinaryProfit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\SettingsBundle\Entity\MemberStatus")
     * @ORM\JoinColumn(name="status_from", referencedColumnName="id", unique=false)
     */
    protected $statusFrom;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\SettingsBundle\Entity\MemberStatus")
     * @ORM\JoinColumn(name="status_to", referencedColumnName="id", unique=false)
     */
    protected $statusTo;

    /**
     * @ORM\Column(type="integer")
     */
    protected $points;

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
     * Set points
     *
     * @param integer $points
     *
     * @return BinaryProfit
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set statusFrom
     *
     * @param \Admin\SettingsBundle\Entity\MemberStatus $statusFrom
     *
     * @return BinaryProfit
     */
    public function setStatusFrom(MemberStatus $statusFrom = null)
    {
        $this->statusFrom = $statusFrom;

        return $this;
    }

    /**
     * Get statusFrom
     *
     * @return \Admin\SettingsBundle\Entity\MemberStatus
     */
    public function getStatusFrom()
    {
        return $this->statusFrom;
    }

    /**
     * Set statusTo
     *
     * @param \Admin\SettingsBundle\Entity\MemberStatus $statusTo
     *
     * @return BinaryProfit
     */
    public function setStatusTo(MemberStatus $statusTo = null)
    {
        $this->statusTo = $statusTo;

        return $this;
    }

    /**
     * Get statusTo
     *
     * @return \Admin\SettingsBundle\Entity\MemberStatus
     */
    public function getStatusTo()
    {
        return $this->statusTo;
    }
}
