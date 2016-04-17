<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/15/16
 * Time: 3:58 PM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class UserWithdraw
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_withdraw")
 */
class UserWithdraw
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="withdraw")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="WalletBundle\Entity\TypeWithdraw", inversedBy="userWithdraw")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $account;

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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserWithdraw
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

    /**
     * Set type
     *
     * @param \WalletBundle\Entity\TypeWithdraw $type
     *
     * @return UserWithdraw
     */
    public function setType(TypeWithdraw $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \WalletBundle\Entity\TypeWithdraw
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return UserWithdraw
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }
}
