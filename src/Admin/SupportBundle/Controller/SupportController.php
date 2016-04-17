<?php

namespace Admin\SupportBundle\Controller;

use Admin\SupportBundle\Form\Type\ReplySupportTicketFormType;
use Admin\SupportBundle\Grid\Column\TicketNumberColumn;
use Admin\SupportBundle\Grid\Column\TicketStatusColumn;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Entity\ReplySupportTicket;

/**
 * Class SupportController
 * @package Admin\SupportBundle\Controller
 */
class SupportController extends Controller
{
    /**
     * @return array
     *
     * @Route("/all-tickets", name="admin_support_all_tickets")
     */
    public function allTicketsAction()
    {
        $source = new Entity('TicketBundle:SupportTicket');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(
            array(
                'id',
                'text',
                'ticketNumber',
                'status',
            )
        );

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('text')->setFilterable(false);
        $grid->getColumn('status')->setTitle('Статус')->setFilterType('select')
            ->setOperators(array('eq'))
            ->setDefaultOperator('eq')
            ->setOperatorsVisible(false)
            ->setSelectFrom('values')
            ->setValues(array(0 => 'Open', 1 => 'Answered', 2 => 'Awaiting reply', 3 => 'Close'));
        $grid->getColumn('dateSubmitted')->setTitle('Дата создания')->setFilterable(false);

        $grid->getColumn('ticketNumber')->setFilterable(false);

        $grid->getColumn('subject')->setTitle('Тема')->setFilterable(false);
        $grid->getColumn('lastUpdate')->setTitle('Последнее обновление')->setFilterable(false);


        $membership = new TextColumn(
            array(
                'id' => 'user',
                'field' => 'user.username',
                'title' => 'Отправитель',
                'source' => true,
            )
        );
        $membership
            ->setOperators(array('like'))
            ->setDefaultOperator('like')
            ->setOperatorsVisible(false);
        $grid->addColumn($membership, 5);

        $ticketNumber = new TicketNumberColumn(array(
            'id'    => 'number',
            'title' => 'Ticket ID',
        ));
        $ticketNumber->manipulateRenderCell(
            function ($value, $row, $router) {
                return array(
                    $row->getField('ticketNumber') => $router->generate('admin_support_reply_ticket', array('id' => $row->getField('id'))),
                );
            }
        );
        $ticketNumber
            ->setFilterable(false);
        $grid->addColumn($ticketNumber, 1);

        $status = new TicketStatusColumn(array(
            'id'    => 'Status',
            'title'    => 'Статус',
        ));
        $status->manipulateRenderCell(
            function ($value, $row, $router) {
                return $row->getField('status');
            }
        )->setAlign('center');
        $status
            ->setFilterable(false);
        $grid->addColumn($status);

        $massAction = new DeleteMassAction(true);
        $massAction->setConfirm(true);
        $grid->addMassAction($massAction);

        $massAction = new MassAction('Open', 'Admin\SupportBundle\Controller\SupportController::openTickets', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($massAction);

        $massAction = new MassAction('Close', 'Admin\SupportBundle\Controller\SupportController::closeTickets', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($massAction);

        $grid->setDefaultOrder('id', 'DESC');

        return $grid->getGridResponse('AdminSupportBundle::all_tickets.html.twig');
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return array
     *
     * @Route("/reply-ticket/{id}", name="admin_support_reply_ticket")
     * @Template("AdminSupportBundle::reply_ticket.html.twig")
     */
    public function replyTicketAction(Request $request, $id)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('TicketBundle:SupportTicket')->find($id);
        $qb = $em->getRepository('TicketBundle:ReplySupportTicket')->createQueryBuilder('rt');
        $qb
            ->where('rt.supportTicket = :ticket')
            ->setParameter('ticket', $ticket)
            ->orderBy('rt.id', 'ASC');
        $replyTicket = $qb->getQuery()->getResult();

        $form = $this->createForm(new ReplySupportTicketFormType(), new ReplySupportTicket());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /* @var $reply ReplySupportTicket */
                $reply = $form->getData();
//                $reply->setUser($this->getUser());
                $date = new \DateTime();
                $reply->setDate($date);
                $reply->setSupportTicket($ticket);
                $ticket->setLastUpdate($date);
                if ($form->get('closed')->getData()) {
                    $ticket->setStatus(3);
                } else {
                    $ticket->setStatus(1);
                }

                $em->persist($reply);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Ticket replied')
                    ->setFrom('admin@ethereumpro.org', 'Support EthereumPro')
                    ->setTo($reply->getSupportTicket()->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/admin_ticket.html.twig',
                            array(
//                                'link' => $this->generateUrl('office_support'),
                                'user' => $reply->getSupportTicket()->getUser()->getUsername(),
//                                'ticket'    => $supportTicket->getTicketNumber(),
                                'subject'    => $reply->getSupportTicket()->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirect($this->generateUrl('admin_support_reply_ticket', array('id'  => $id)));
            }
        }

        return array(
            'ticket'        => $ticket,
            'reply_ticket'  => $replyTicket,
            'form'          => $form->createView(),
        );
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function openTickets($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];

        foreach ($primaryKeys as $ticketId) {
            /* @var $statistic \TicketBundle\Entity\SupportTicket */
            $ticket = $em->getRepository('TicketBundle:SupportTicket')->find($ticketId);
            $ticket->setStatus(0);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function closeTickets($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];

        foreach ($primaryKeys as $ticketId) {
            /* @var $statistic \TicketBundle\Entity\SupportTicket */
            $ticket = $em->getRepository('TicketBundle:SupportTicket')->find($ticketId);
            $ticket->setStatus(3);
            $em->flush();
        }
    }
}
