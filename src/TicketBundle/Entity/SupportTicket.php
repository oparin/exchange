<?php
/**
 * Created by PhpStorm.
 * User: oparin
 * Date: 7/23/15
 * Time: 3:10 PM
 */

namespace TicketBundle\Entity;

use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SupportTicket
 * @package Matrix\OfficeBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="support_tickets")
 */
class SupportTicket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="date_submitted")
     */
    protected $dateSubmitted;

    /**
     * @ORM\Column(type="string")
     */
    protected $ticketNumber;

    /**
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="supportTickets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * 0 - Open ticket
     * 1 - Answered
     * 2 - Awaiting reply
     * 3 - Closed
     *
     * @ORM\Column(type="smallint")
     */
    protected $status = 0;

    /**
     * @ORM\Column(type="datetime", name="last_update")
     */
    protected $lastUpdate;

    /**
     * @ORM\OneToMany(targetEntity="TicketBundle\Entity\ReplySupportTicket", mappedBy="supportTicket", cascade={"persist", "remove"})
     */
    protected $replySupportTickets;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replySupportTickets = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateSubmitted
     *
     * @param \DateTime $dateSubmitted
     *
     * @return SupportTicket
     */
    public function setDateSubmitted($dateSubmitted)
    {
        $this->dateSubmitted = $dateSubmitted;

        return $this;
    }

    /**
     * Get dateSubmitted
     *
     * @return \DateTime
     */
    public function getDateSubmitted()
    {
        return $this->dateSubmitted;
    }

    /**
     * Set ticketNumber
     *
     * @param string $ticketNumber
     *
     * @return SupportTicket
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * Get ticketNumber
     *
     * @return string
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return SupportTicket
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return SupportTicket
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
     * Set status
     *
     * @param integer $status
     *
     * @return SupportTicket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return SupportTicket
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return SupportTicket
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
     * Add replySupportTicket
     *
     * @param \TicketBundle\Entity\ReplySupportTicket $replySupportTicket
     *
     * @return SupportTicket
     */
    public function addReplySupportTicket(ReplySupportTicket $replySupportTicket)
    {
        $this->replySupportTickets[] = $replySupportTicket;

        return $this;
    }

    /**
     * Remove replySupportTicket
     *
     * @param \TicketBundle\Entity\ReplySupportTicket $replySupportTicket
     */
    public function removeReplySupportTicket(ReplySupportTicket $replySupportTicket)
    {
        $this->replySupportTickets->removeElement($replySupportTicket);
    }

    /**
     * Get replySupportTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplySupportTickets()
    {
        return $this->replySupportTickets;
    }
}
