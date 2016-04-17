<?php

namespace TicketBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TicketBundle\Entity\ReplySupportTicket;
use TicketBundle\Entity\SupportTicket;
use TicketBundle\Form\Type\NewSupportTicketFormType;
use TicketBundle\Form\Type\ReplySupportTicketFormType;

/**
 * Class TicketController
 * @package TicketBundle\Controller
 */
class TicketController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/new-ticket", name="office_new_ticket")
     * @Template("TicketBundle::new_ticket.html.twig")
     */
    public function newTicketAction(Request $request)
    {
        $form = $this->createForm(new NewSupportTicketFormType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /* @var $supportTicket SupportTicket */
                $supportTicket = $form->getData();
                $date = new \DateTime();
                $supportTicket->setDateSubmitted($date);
                $supportTicket->setLastUpdate($date);
                $supportTicket->setTicketNumber(substr(md5(time()), 0, 12));
                $supportTicket->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($supportTicket);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('New Ticket')
//                    ->setFrom(array('support@yoxa.biz' => 'Служба поддержки Yoxa'))
                    ->setFrom('admin@ethereumpro.org', 'Support EthereumPro')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/new_ticket.html.twig',
                            array(
//                                'link' => $this->generateUrl('office_support'),
                                'user' => $supportTicket->getUser()->getUsername(),
//                                'ticket'    => $supportTicket->getTicketNumber(),
                                'subject'    => $supportTicket->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->addFlash('success', $this->get('translator')->trans('support.send_success'));

                return $this->redirectToRoute('office_new_ticket');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return array
     *
     * @Route("/view-ticket/{id}", name="office_support_view_ticket")
     * @Template("TicketBundle::view_ticket.html.twig")
     */
    public function viewTicketAction(Request $request, $id)
    {
        $user   = $this->getUser();

        /** @var  $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('TicketBundle:SupportTicket')->findOneBy(array(
            'id'    => $id,
            'user'  => $user,
        ));

        if (!$ticket) {
            throw new NotFoundHttpException('Not Found!');
        }
        $qb = $em->getRepository('TicketBundle:ReplySupportTicket')->createQueryBuilder('rt');
        $qb
            ->where('rt.supportTicket = :ticket')
            ->setParameter('ticket', $ticket)
            ->orderBy('rt.id', 'ASC');
        $replyTicket = $qb->getQuery()->getResult();

        $form = $this->createForm(new ReplySupportTicketFormType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /* @var $reply ReplySupportTicket */
                $reply = $form->getData();
                $reply->setUser($this->getUser());
                $date = new \DateTime();
                $reply->setDate($date);
                $reply->setSupportTicket($ticket);
                $ticket->setLastUpdate($date);
                $ticket->setStatus(2);

                $em->persist($reply);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Reply noted')
                    ->setFrom('admin@ethereumpro.org', 'Support EthereumPro')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/reply_ticket.html.twig',
                            array(
//                                'link' => $this->generateUrl('office_support'),
                                'user' => $reply->getUser()->getUsername(),
//                                'ticket'    => $supportTicket->getTicketNumber(),
//                                'subject'    => $reply->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('support.send_success')
                );

                return $this->redirectToRoute('office_support_view_ticket', array('id' => $id));
            }
        }

        return array(
            'ticket'        => $ticket,
            'reply_ticket'  => $replyTicket,
            'form'          => $form->createView(),
        );
    }
}
