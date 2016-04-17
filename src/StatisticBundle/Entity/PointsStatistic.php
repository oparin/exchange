<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/21/16
 * Time: 4:05 PM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class PointsStatistic
 *
 * @ORM\Entity
 * @ORM\Table(name="points_statistic")
 */
class PointsStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="statisticPoints")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer", name="left_points")
     */
    protected $leftPoints;

    /**
     * @ORM\Column(type="integer", name="right_points")
     */
    protected $rightPoints;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $bonus;

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
     * @return PointsStatistic
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
     * Set leftPoints
     *
     * @param integer $leftPoints
     *
     * @return PointsStatistic
     */
    public function setLeftPoints($leftPoints)
    {
        $this->leftPoints = $leftPoints;

        return $this;
    }

    /**
     * Get leftPoints
     *
     * @return integer
     */
    public function getLeftPoints()
    {
        return $this->leftPoints;
    }

    /**
     * Set rightPoints
     *
     * @param integer $rightPoints
     *
     * @return PointsStatistic
     */
    public function setRightPoints($rightPoints)
    {
        $this->rightPoints = $rightPoints;

        return $this;
    }

    /**
     * Get rightPoints
     *
     * @return integer
     */
    public function getRightPoints()
    {
        return $this->rightPoints;
    }

    /**
     * Set bonus
     *
     * @param string $bonus
     *
     * @return PointsStatistic
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return string
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return PointsStatistic
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
