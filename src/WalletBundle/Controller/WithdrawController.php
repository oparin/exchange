<?php

namespace WalletBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserWithdraw;
use WalletBundle\Event\WalletEvent;
use WalletBundle\Form\Type\WithdrawFormType;
use WalletBundle\Grid\Column\StatusColumn;
use WalletBundle\WalletEvents;

/**
 * Class WithdrawController
 * @package WalletBundle\Controller
 */
class WithdrawController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/withdraw", name="office_withdraw")
     * @Template("WalletBundle:Withdraw:withdraw.html.twig")
     */
    public function indexAction(Request $request)
    {
        /** @var  $em EntityManager */
        $em     = $this->getDoctrine()->getManager();

        /** @var  $user User */
        $user   = $this->getUser();

        $form = $this->createForm(new WithdrawFormType($user));

        $qb = $em->getRepository('WalletBundle:UserWallet')->createQueryBuilder('uw');
        $qb
            ->select('uw.sum')
            ->leftJoin('uw.type', 't')
            ->where('uw.user = :user')
            ->andWhere("t.name = 'M'")
            ->setParameter('user', $user);
        $maxSum = $qb->getQuery()->getSingleScalarResult();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum = $form->get('sum')->getData();
                if ($sum <= $maxSum) {
                    if ($sum >= 50) {
                        /** @var $type UserWithdraw */
                        $type = $form->get('type')->getData();
                        $qb = $em->getRepository('WalletBundle:UserWallet')->createQueryBuilder('uw');
                        $qb
                            ->leftJoin('uw.type', 't')
                            ->where('uw.user = :user')
                            ->andWhere("t.name = 'M'")
                            ->setParameter('user', $user);
                        $wallet = $qb->getQuery()->getOneOrNullResult();

                        $wallet->setSum($wallet->getSum() - $sum);
                        $sum = $sum - $sum * 1.5 / 100;

                        $event = new WalletEvent($user, $sum, $type->getType()->getName(), $type->getAccount());
                        $dispatcher = $this->get('event_dispatcher');
                        $dispatcher->dispatch(WalletEvents::PAYOUT_WALLET, $event);

//                        $event = new LogEvent($user, 2);
//                        $dispatcher->dispatch('save_log', $event);

                        // Save Transaction
                        $mainType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                            'name'  => 'M',
                        ));
                        $mainWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $mainType,
                        ));
                        $mainAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $mainType,
                        ));

                        $bonusType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                            'name'  => 'B',
                        ));
                        $bonusWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $bonusType,
                        ));
                        $bonusAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $bonusType,
                        ));

                        $event = new TransactionEvent($user, $sum, $mainWallet->getSum(), $bonusWallet->getSum(), $mainAccount->getSum(), $bonusAccount->getSum(), 0);
                        $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                        $this->get('session')->getFlashBag()->add(
                            'success',
                            $this->get('translator')->trans('withdraw.request_submitted_success')
                        );
                    } else {
                        $this->get('session')->getFlashBag()->add(
                            'error',
                            $this->get('translator')->trans('withdraw.min_sum')
                        );
                    }

                    return $this->redirect($this->generateUrl('office_withdraw_statistic'));
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'error',
                        $this->get('translator')->trans('withdraw.no_funds')
                    );
                }
            }
        }

        return array(
            'form'      => $form->createView(),
            'max_sum'   => $maxSum,
        );
    }

    /**
     * @return array
     *
     * @Route("/withdraw-statistic", name="office_withdraw_statistic")
     * @Template("WalletBundle:Withdraw:withdraw_statistic.html.twig")
     */
    public function statisticAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $source = new Entity('StatisticBundle:WalletStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->andWhere($tableAlias.'.type = false')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'hash',
        ));

        $translator = $this->get('translator');

        $statusColumn = new StatusColumn(array(
            'id'        => 'status',
            'title'     => $translator->trans('withdraw.status'),
        ));
        $grid->addColumn($statusColumn);



        $grid->getColumn('date')->setTitle($translator->trans('deposit.date'));
        $grid->getColumn('sum')->setTitle($translator->trans('deposit.sum'));
        $grid->getColumn('system')->setTitle($translator->trans('deposit.system'));
        $grid->getColumn('account')->setTitle($translator->trans('deposit.account'));

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}
