<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.03.2016
 * Time: 11:07
 */

namespace OfficeBundle\Controller;

use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\MiningHistory;
use StatisticBundle\Entity\MiningStatistic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserWallet;

/**
 * Class MiningPoolController
 * @package OfficeBundle\Controller
 */
class MiningPoolController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/minign-pool/mining", name="office_mining_pool_mining")
     * @Template("OfficeBundle:MiningPool:mining.html.twig")
     */
    public function miningAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $rates = $em->getRepository('AdminMiningBundle:Rate')->findOneBy(array());

        /** @var $user User */
        $user = $this->getUser();

        $settings = $em->getRepository('AdminMiningBundle:Settings')->findOneBy(array());
        $translator = $this->get('translator');

        // Form for Buy
        $formBuy = $this->get("form.factory")->createNamedBuilder("form_buy")
            ->add('miningRights', 'number', array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'mining.mining_rights',
            ))
            ->getForm();

        // Form for Send Pool
        $formSendToPool = $this->get("form.factory")->createNamedBuilder("form_send_to_pool")
            ->add('miningRights', 'number', array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'mining.mining_rights',
            ))
            ->getForm();

        // Form for Sell
        $formSell = $this->get("form.factory")->createNamedBuilder("form_sell")
            ->add('amount', 'number', array(
                'constraints'   => array(new NotBlank()),
                'label'         => $this->get('service_container')->getParameter('currency').' '.$translator->trans('mining.amount'),
            ))
            ->getForm();

        // Form for Convert
        $formConvert = $this->get("form.factory")->createNamedBuilder("form_convert")
            ->add('miningRights', 'number', array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'mining.mining_rights',
            ))
            ->getForm();

        // Set Grid
        $source = new Entity('StatisticBundle:MiningStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $grid->getColumn('startDate')->setTitle($translator->trans('mining.start_date'))->manipulateRenderCell(
            function ($value, $row, $router) use ($translator) {
                /* @var $row Row */
                /** @var $date \DateTime */
                $date = $row->getField('startDate');

                return $date->format('d/m/Y');
            }
        );
        $grid->getColumn('endDate')->setTitle($translator->trans('mining.end_date'))->manipulateRenderCell(
            function ($value, $row, $router) use ($translator) {
                /* @var $row Row */
                /** @var $date \DateTime */
                $date = $row->getField('endDate');

                return $date->format('d/m/Y');
            }
        );
        $grid->getColumn('miningRights')->setTitle($translator->trans('mining.mining_rights'));
        $grid->getColumn('duration')->setTitle($translator->trans('mining.duration'));
        $grid->getColumn('status')->setTitle($translator->trans('mining.status'))->manipulateRenderCell(
            function ($value, $row, $router) use ($translator) {
                /* @var $row Row */
                if ($row->getField('status') == false) {
                    $result = $translator->trans('mining.in_progress');
                } else {
                    $result = $translator->trans('mining.finished');
                }

                return $result;
            }
        )->setAlign('center')->setSize(100);

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(20);

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        if ($request->request->has("form_buy")) {
            $formBuy->handleRequest($request);
            if ($formBuy->isValid()) {
                if ($user->getStatus()) {
                    $accounts = $user->getAccounts();
                    /** @var $mainAccount UserAccount */
                    $mainAccount = $accounts[0];
                    $rights = $formBuy->get('miningRights')->getData();
                    if ($mainAccount->getSum() >= $rights * $rates->getBuy()) {
                        $mainAccount->setSum($mainAccount->getSum() - $rights * $rates->getBuy());
                        $user->setMiningRights($user->getMiningRights() + $rights);

                        // Save History
                        $history = new MiningHistory();
                        $history->setUser($user);
                        $history->setDate(new \DateTime());
                        $history->setTransaction(0);
                        $history->setAmount($rights);
                        $history->setMiningRights($user->getMiningRights());
                        $history->setMiningRightsInWork($user->getMiningRightsInWork());
                        $history->setPoolWallet($user->getPoolWallet());
                        $em->persist($history);

                        $em->flush();

                        $this->addFlash('success', $translator->trans('mining.buy_success'));

                        return $this->redirectToRoute('office_mining_pool_mining');
                    } else {
                        $this->addFlash('error', $translator->trans('mining.not_funds'));
                    }
                } else {
                    $this->addFlash('error', $translator->trans('mining.no_status'));
                }
            }
        }

        if ($request->request->has("form_send_to_pool")) {
            $formSendToPool->handleRequest($request);
            if ($formSendToPool->isValid()) {
                $rights = $formSendToPool->get('miningRights')->getData();
                if ($user->getMiningRights() >= $rights) {
                    $user->setMiningRights($user->getMiningRights() - $rights);
                    $user->setMiningRightsInWork($user->getMiningRightsInWork() + $rights);

                    //Save Statistic
                    $miningSettings = $em->getRepository('AdminMiningBundle:Settings')->findOneBy(array());
                    $statistic = new MiningStatistic();
                    $date = new \DateTime();
                    $statistic->setUser($user);
                    $statistic->setStartDate(new \DateTime());
                    $statistic->setEndDate($date->modify('+ '.$miningSettings->getDuration().' day'));
                    $statistic->setMiningRights($rights);
                    $statistic->setDuration($miningSettings->getDuration());
                    $em->persist($statistic);

                    // Save History
                    $history = new MiningHistory();
                    $history->setUser($user);
                    $history->setDate(new \DateTime());
                    $history->setTransaction(1);
                    $history->setAmount($rights);
                    $history->setMiningRights($user->getMiningRights());
                    $history->setMiningRightsInWork($user->getMiningRightsInWork());
                    $history->setPoolWallet($user->getPoolWallet());
                    $em->persist($history);

                    $em->flush();

                    $this->addFlash('success', $translator->trans('mining.send_success'));

                    return $this->redirectToRoute('office_mining_pool_mining');
                } else {
                    $this->addFlash('error', $translator->trans('mining.not_funds'));
                }
            }
        }

        if ($request->request->has("form_sell")) {
            $formSell->handleRequest($request);
            if ($formSell->isValid()) {
                $amount = $formSell->get('amount')->getData();
                if ($user->getPoolWallet() >= $amount) {
                    $wallets = $user->getWallets();
                    /** @var $wallet UserWallet */
                    $wallet = $wallets[0];
                    $user->setPoolWallet($user->getPoolWallet() - $amount);
                    $wallet->setSum($wallet->getSum() + $amount * $rates->getSell());

                    // Save History
                    $history = new MiningHistory();
                    $history->setUser($user);
                    $history->setDate(new \DateTime());
                    $history->setTransaction(2);
                    $history->setAmount($amount);
                    $history->setMiningRights($user->getMiningRights());
                    $history->setMiningRightsInWork($user->getMiningRightsInWork());
                    $history->setPoolWallet($user->getPoolWallet());
                    $em->persist($history);

                    $em->flush();

                    $this->addFlash('success', $translator->trans('mining.sell_success'));

                    return $this->redirectToRoute('office_mining_pool_mining');
                } else {
                    $this->addFlash('error', $translator->trans('mining.not_funds'));
                }
            }
        }

        if ($request->request->has("form_convert")) {
            $formConvert->handleRequest($request);
            if ($formConvert->isValid()) {
                $rights = $formConvert->get('miningRights')->getData();
                if ($user->getPoolWallet() >= $rights) {
                    $user->setPoolWallet($user->getPoolWallet() - $rights);
                    $user->setMiningRights($user->getMiningRights() + $rights * $rates->getConvertat());

                    // Save History
                    $history = new MiningHistory();
                    $history->setUser($user);
                    $history->setDate(new \DateTime());
                    $history->setTransaction(3);
                    $history->setAmount($rights);
                    $history->setMiningRights($user->getMiningRights());
                    $history->setMiningRightsInWork($user->getMiningRightsInWork());
                    $history->setPoolWallet($user->getPoolWallet());
                    $em->persist($history);

                    $em->flush();

                    $this->addFlash('success', $translator->trans('mining.convert_success'));

                    return $this->redirectToRoute('office_mining_pool_mining');
                } else {
                    $this->addFlash('error', $translator->trans('mining.not_funds'));
                }
            }
        }

        $statistic = $em->getRepository('AdminMiningBundle:SplitStatistic')->findAll();

        return array(
            'statistics'        => $statistic,
            'form_buy'          => $formBuy->createView(),
            'form_send_to_pool' => $formSendToPool->createView(),
            'form_sell'         => $formSell->createView(),
            'form_convert'      => $formConvert->createView(),
            'rates'             => $rates,
            'settings'          => $settings,
            'grid'              => $grid,
        );
    }

    /**
     * @return array
     *
     * @Route("/minign-pool/history", name="office_mining_pool_history")
     * @Template("OfficeBundle:MiningPool:history.html.twig")
     */
    public function historyAction()
    {
        // Set Grid
        $source = new Entity('StatisticBundle:MiningHistory');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $translator = $this->get('translator');

        $grid->getColumn('date')->setTitle($translator->trans('mining.date'))->manipulateRenderCell(
            function ($value, $row, $router) use ($translator) {
                /* @var $row Row */
                /** @var $date \DateTime */
                $date = $row->getField('date');

                return $date->format('d/m/Y');
            }
        );

        $grid->getColumn('transaction')->setTitle($translator->trans('mining.transaction'))->manipulateRenderCell(
            function ($value, $row, $router) use ($translator) {
                switch ($value) {
                    case 0:
                        $result = $translator->trans('mining.buy_mining_rights');
                        break;
                    case 1:
                        $result = $translator->trans('mining_pool.send_to_pool');
                        break;
                    case 2:
                        $result = $translator->trans('mining.sell').' '.$this->get('service_container')->getParameter('currency');
                        break;
                    case 3:
                        $result = $translator->trans('mining.convert').' '.$this->get('service_container')->getParameter('currency');
                        break;
                    default:
                        $result = 'test';
                        break;
                }

                return $result;
            }
        );

        $grid->getColumn('amount')->setTitle($translator->trans('mining.amount'));
        $grid->getColumn('miningRights')->setTitle($translator->trans('mining.mining_rights'));
        $grid->getColumn('miningRightsInWork')->setTitle($translator->trans('mining_pool.mining_rights_in_work'));
        $grid->getColumn('poolWallet')->setTitle($translator->trans('mining_pool.pool_wallet'));

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(20);

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}
