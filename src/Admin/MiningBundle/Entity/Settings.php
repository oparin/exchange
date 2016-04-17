<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 06.04.16
 * Time: 10:21
 */

namespace Admin\MiningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 * @package Admin\MiningBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mining_settings")
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="progress_bar")
     */
    protected $progressBar;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $multiplier;

    /**
     * @ORM\Column(type="integer")
     */
    protected $duration;

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
     * Set progressBar
     *
     * @param integer $progressBar
     *
     * @return Settings
     */
    public function setProgressBar($progressBar)
    {
        $this->progressBar = $progressBar;

        return $this;
    }

    /**
     * Get progressBar
     *
     * @return integer
     */
    public function getProgressBar()
    {
        return $this->progressBar;
    }

    /**
     * Set multiplier
     *
     * @param integer $multiplier
     *
     * @return Settings
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
     * Set duration
     *
     * @param integer $duration
     *
     * @return Settings
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
}
