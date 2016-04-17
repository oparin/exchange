<?php

namespace OfficeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 * @package OfficeBundle\Controller
 */
class DashboardController extends Controller
{
    /**
     * @return array
     *
     * @Route("/dashboard", name="office_dashboard")
     * @Template("OfficeBundle:Dashboard:dashboard.html.twig")
     */
    public function dashboardAction()
    {
        $request = $this->get('request');
//        dump($request->getDefaultLocale());exit;
        /** @var  $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        // Get Project Statistic Data
        $qb = $em->getRepository('AdminSettingsBundle:ProjectStatistic')->createQueryBuilder('s');
        $qb
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(14);
        $statistics = $qb->getQuery()->getResult();

        $videos = $em->getRepository('AdminSettingsBundle:VideoSlide')->findAll();

        $user = $this->getUser();

        $qb = $em->getRepository('StatisticBundle:SponsorBonusStatistic')->createQueryBuilder('sbs');
        $qb
            ->leftJoin('sbs.user', 'u')
            ->select('SUM(sbs.bonus)')
            ->where('u.sponsor = :user')
            ->setParameter('user', $user);
        $referralBonus = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('StatisticBundle:WalletStatistic')->createQueryBuilder('ws');
        $qb
            ->select('SUM(ws.sum)')
            ->where('ws.user = :user')
            ->andWhere('ws.type = 1')
            ->andWhere('ws.status = 1')
            ->setParameter('user', $user);
        $allDeposit = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('StatisticBundle:WalletStatistic')->createQueryBuilder('ws');
        $qb
            ->select('SUM(ws.sum)')
            ->where('ws.user = :user')
            ->andWhere('ws.type = 0')
            ->andWhere('ws.status = 1')
            ->setParameter('user', $user);
        $allWithdraw = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('StatisticBundle:PointsStatistic')->createQueryBuilder('ps');
        $qb
            ->select('SUM(ps.bonus)')
            ->where('ps.user = :user')
            ->setParameter('user', $user);
        $pointsBonus = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('ExchangeBundle:Bid')->createQueryBuilder('b');
        $qb
            ->select('COUNT(b.id)')
            ->where('b.user = :user')
            ->andWhere('b.type = 0')
            ->setParameter('user', $user);
        $countBuy = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('ExchangeBundle:Bid')->createQueryBuilder('b');
        $qb
            ->select('COUNT(b.id)')
            ->where('b.user = :user')
            ->andWhere('b.type = 1')
            ->setParameter('user', $user);
        $countSell = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $percent = $countBuy + $countSell;

        return array(
            'statistics'        => array_reverse($statistics),
            'all_news'          => $em->getRepository('AdminNewsBundle:News')->findBy(array(), array('date' => 'DESC')),
            'settings'          => $em->getRepository('AdminSettingsBundle:Settings')->find(1),
            'videos'            => $videos,
            'faqs'              => $em->getRepository('AdminSettingsBundle:Faq')->findBy(array('locale' => $request->getLocale())),
            'count_referrals'   => $em->getRepository('UserBundle:User')->getCountReferrals($user),
            'referral_bonus'    => $referralBonus,
            'all_deposit'       => $allDeposit,
            'all_withdraw'      => $allWithdraw,
            'points_bonus'      => $pointsBonus,
            'server_time'       => new \DateTime('NOW'),
            'buy_percent'       => ($percent) ? $countBuy * 100 / $percent : 0,
            'sell_percent'      => ($percent) ? $countSell * 100 / $percent : 0,
        );
    }
}
