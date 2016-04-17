<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/15/16
 * Time: 3:43 PM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeWithdraw
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="type_withdraw")
 */
class TypeWithdraw
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWithdraw", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $userWithdraw;

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return TypeWithdraw
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userWithdraw = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userWithdraw
     *
     * @param \WalletBundle\Entity\UserWithdraw $userWithdraw
     *
     * @return TypeWithdraw
     */
    public function addUserWithdraw(UserWithdraw $userWithdraw)
    {
        $this->userWithdraw[] = $userWithdraw;

        return $this;
    }

    /**
     * Remove userWithdraw
     *
     * @param \WalletBundle\Entity\UserWithdraw $userWithdraw
     */
    public function removeUserWithdraw(UserWithdraw $userWithdraw)
    {
        $this->userWithdraw->removeElement($userWithdraw);
    }

    /**
     * Get userWithdraw
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserWithdraw()
    {
        return $this->userWithdraw;
    }
}
