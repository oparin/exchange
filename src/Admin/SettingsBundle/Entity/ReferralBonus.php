<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.02.16
 * Time: 9:31
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ReferralBonus
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="referral_bonus_settings")
 */
class ReferralBonus
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
     * Set bonus
     *
     * @param integer $bonus
     *
     * @return ReferralBonus
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return integer
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set statusFrom
     *
     * @param \Admin\SettingsBundle\Entity\MemberStatus $statusFrom
     *
     * @return ReferralBonus
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
     * @return ReferralBonus
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
