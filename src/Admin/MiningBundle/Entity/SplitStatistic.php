<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 08.04.16
 * Time: 10:25
 */

namespace Admin\MiningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SplitStatistic
 * @package Admin\MiningBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="split_statistic")
 */
class SplitStatistic
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
     * @return SplitStatistic
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
}
