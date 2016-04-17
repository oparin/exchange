<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/2/15
 * Time: 10:54 AM
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProjectStatistic
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="project_statistic")
 */
class ProjectStatistic
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
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $maxCourse;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ProjectStatistic
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
     * Set maxCourse
     *
     * @param string $maxCourse
     *
     * @return ProjectStatistic
     */
    public function setMaxCourse($maxCourse)
    {
        $this->maxCourse = $maxCourse;

        return $this;
    }

    /**
     * Get maxCourse
     *
     * @return string
     */
    public function getMaxCourse()
    {
        return $this->maxCourse;
    }
}
