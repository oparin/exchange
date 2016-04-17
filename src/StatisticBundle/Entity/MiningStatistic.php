<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 06.04.16
 * Time: 11:21
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class MiningStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mining_statistic")
 */
class MiningStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="miningStatistic")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime", name="start_date")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime", name="end_date")
     */
    protected $endDate;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights")
     */
    protected $miningRights;

    /**
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * 0 - in progress
     * 1 - finished
     *
     * @ORM\Column(type="boolean")
     */
    protected $status = false;

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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return MiningStatistic
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return MiningStatistic
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set miningRights
     *
     * @param string $miningRights
     *
     * @return MiningStatistic
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
     * Set duration
     *
     * @param integer $duration
     *
     * @return MiningStatistic
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return MiningStatistic
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return MiningStatistic
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
}
