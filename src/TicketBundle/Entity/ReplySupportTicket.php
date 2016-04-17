<?php
/**
 * Created by PhpStorm.
 * User: oparin
 * Date: 7/23/15
 * Time: 3:13 PM
 */

namespace TicketBundle\Entity;

use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ReplySupportTicket
 * @package Matrix\OfficeBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="reply_support_tickets")
 */
class ReplySupportTicket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="TicketBundle\Entity\SupportTicket", inversedBy="replySupportTickets")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $supportTicket;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="replySupportTickets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime", name="date")
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
     * Set text
     *
     * @param string $text
     *
     * @return ReplySupportTicket
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ReplySupportTicket
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
     * Set supportTicket
     *
     * @param \TicketBundle\Entity\SupportTicket $supportTicket
     *
     * @return ReplySupportTicket
     */
    public function setSupportTicket(SupportTicket $supportTicket = null)
    {
        $this->supportTicket = $supportTicket;

        return $this;
    }

    /**
     * Get supportTicket
     *
     * @return \TicketBundle\Entity\SupportTicket
     */
    public function getSupportTicket()
    {
        return $this->supportTicket;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return ReplySupportTicket
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
