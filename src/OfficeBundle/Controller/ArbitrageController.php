<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 12:14 PM
 */

namespace OfficeBundle\Controller;

use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use OfficeBundle\Entity\ArbitrageCredit;
use OfficeBundle\Form\Type\ArbitrageFormType;
use OfficeBundle\Grid\Column\ArbitrageStatusColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Class ArbitrageController
 * @package OfficeBundle\Controller
 */
class ArbitrageController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/arbitrage", name="office_arbitrage")
     * @Template("OfficeBundle:Arbitrage:arbitrage.html.twig")
     */
    public function arbitrageAction(Request $request)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        /* @var $user User */
        $user       = $this->getUser();
        $settings   = $em->getRepository('AdminSettingsBundle:ArbitrageSettings')->find(1);

        $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
            'name'  => 'M',
        ));

        $userAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
            'type'  => $typeBalance,
            'user'  => $user,
        ));

        // Sum on wallet
        $amount     = $userAccount->getSum();

        $qb         = $em->getRepository('OfficeBundle:ArbitrageCredit')->createQueryBuilder('ac');
        $qb
            ->select('SUM(ac.sum)')
            ->where('ac.user = :user')
            ->andWhere('ac.status <> 1')
            ->setParameter('user', $user);
        $sum = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        // Available amount
        $amount = $amount - $sum;

        $commission = $settings->getCommission();

        $form = $this->createForm(new ArbitrageFormType());

        // Statistic
        $source = new Entity('OfficeBundle:ArbitrageCredit');

        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias, $user) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->setParameter('user', $user);
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'multiplier',
            'status',
            'prolongation',
            'fineDate',
        ));

        $translator = $this->get('translator');
        $grid
            ->getColumn('sum')
            ->setTitle($translator->trans('arbitrage.sum_loan'))
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    /** @var  $row Row */
                    $sum    = $row->getField('sum');
                    $multi  = $row->getField('multiplier');

                    return $sum * $multi.' $';
                }
            );

        $grid
            ->getColumn('days')
            ->setTitle($translator->trans('arbitrage.count_days'))
            ->setAlign('center');

        $grid
            ->getColumn('percent')
            ->setTitle($translator->trans('arbitrage.percent'))
            ->setAlign('center');

        $grid
            ->getColumn('dateStart')
            ->setTitle($translator->trans('arbitrage.date_start'))
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    /** @var  $row Row */
                    $date    = $row->getField('dateStart');

                    return $date->format('d/m/Y h:i');
                }
            );

        $grid
            ->getColumn('returnSum')
            ->setTitle($translator->trans('arbitrage.return_sum'))
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    return $value.' $';
                }
            );

        $grid
            ->getColumn('dateEnd')
            ->setTitle($translator->trans('arbitrage.date_end'))
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    /** @var  $row Row */
                    $date    = $row->getField('dateEnd');

                    return $date->format('d/m/Y h:i');
                }
            );

        $grid
            ->getColumn('status')
            ->setTitle($translator->trans('arbitrage.status'))
            ->setAlign('center');

        $status = new ArbitrageStatusColumn(array(
            'id'    => 'Status',
            'title' => $translator->trans('arbitrage.status'),
        ));
        $status->manipulateRenderCell(
            function ($value, $row, $router) {
                /** @var  $row Row */
                $status    = $row->getField('status');

                return $status;
            }
        )->setAlign('center');
        $grid->addColumn($status);

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(20);

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        if ($request->isMethod("POST")) {
            if (!$sum) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    if ($amount >= 50) {
                        if ($amount >= 1000) {
                            $percent = 0.4;
                        } else {
                            $percent = $commission;
                        }
                        $credit = new ArbitrageCredit();
                        $credit->setSum($amount);
                        $days = $form->get('day')->getData();
                        $credit->setDays($days);
                        $credit->setPercent($percent);
                        $credit->setUser($user);
                        $credit->setMultiplier($settings->getMultiplier());
                        $credit->setDateStart(new \DateTime());
                        $date = new \DateTime();
                        $credit->setDateEnd($date->modify('+'.$days.' day'));
                        $sum = $amount * $settings->getMultiplier();
                        if ($sum > $settings->getArbitrageMaxSum()) {
                            $sum = $settings->getArbitrageMaxSum();
                        }
                        $profit = $days * $percent / 100 * $sum;
                        $credit->setReturnSum($profit + $sum);

                        $arbitrageType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array('name' => 'A'));
                        $arbitrageAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $arbitrageType,
                        ));
                        $arbitrageAccount->setSum($arbitrageAccount->getSum() + $sum);
                        $em->persist($credit);
                        $em->flush();

//                        $dispatcher = $this->get('event_dispatcher');
//                        $event = new LogEvent($user, 5);
//                        $dispatcher->dispatch('save_log', $event);

                        $this->addFlash(
                            'success',
                            $this->get('translator')->trans('arbitrage.credit_success')
                        );

                        return $this->redirectToRoute('office_arbitrage');
                    } else {
                        $this->addFlash(
                            'error',
                            $this->get('translator')->trans('arbitrage.error_add_funds')
                        );
                    }
                }
            } else {
                $this->addFlash(
                    'error',
                    $this->get('translator')->trans('arbitrage.outstanding_loan')
                );
            }
        }

        return array(
            'form'          => $form->createView(),
            'commission'    => $commission,
            'amount'        => $amount,
            'settings'      => $settings,
            'grid'          => $grid,
        );
    }
}
