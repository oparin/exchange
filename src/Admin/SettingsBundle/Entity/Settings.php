<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 4:03 PM
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="settings")
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
     * @ORM\Column(type="string", name="site_name")
     */
    protected $siteName;

    /**
     * @ORM\Column(type="decimal", scale=2, name="registration_bonus")
     */
    protected $registrationBonus = 0.00;

    /**
     * @ORM\Column(type="text", name="ticker_one")
     */
    protected $tickerOne;

    /**
     * @ORM\Column(type="text", name="ticker_two")
     */
    protected $tickerTwo;

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
     * Set siteName
     *
     * @param string $siteName
     *
     * @return Settings
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set registrationBonus
     *
     * @param string $registrationBonus
     *
     * @return Settings
     */
    public function setRegistrationBonus($registrationBonus)
    {
        $this->registrationBonus = $registrationBonus;

        return $this;
    }

    /**
     * Get registrationBonus
     *
     * @return string
     */
    public function getRegistrationBonus()
    {
        return $this->registrationBonus;
    }

    /**
     * Set tickerOne
     *
     * @param string $tickerOne
     *
     * @return Settings
     */
    public function setTickerOne($tickerOne)
    {
        $this->tickerOne = $tickerOne;

        return $this;
    }

    /**
     * Get tickerOne
     *
     * @return string
     */
    public function getTickerOne()
    {
        return $this->tickerOne;
    }

    /**
     * Set tickerTwo
     *
     * @param string $tickerTwo
     *
     * @return Settings
     */
    public function setTickerTwo($tickerTwo)
    {
        $this->tickerTwo = $tickerTwo;

        return $this;
    }

    /**
     * Get tickerTwo
     *
     * @return string
     */
    public function getTickerTwo()
    {
        return $this->tickerTwo;
    }
}
