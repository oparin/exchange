<?php

namespace Admin\WalletBundle\Controller;

use Admin\WalletBundle\Grid\Column\StatusColumn;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\WalletStatistic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class WalletController
 * @package Admin\WalletBundle\Controller
 */
class WalletController extends Controller
{
    /**
     * @return array
     *
     * @Route("/wallet-deposit", name="admin_wallet_deposit")
     * @Template("AdminWalletBundle::deposit.html.twig")
     */
    public function depositAction()
    {
        $source = new Entity('\StatisticBundle\Entity\WalletStatistic');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.type = true')
                    ->andWhere($tableAlias.'.status = 1');
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'hash',
        ));

        $user = new TextColumn(array(
            'id'    => 'username',
            'field' => 'user.username',
            'source'    => true,
            'title' => 'User',
        ));
        $grid->addColumn($user, 1);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @return array
     *
     * @Route("/wallet-withdraw", name="admin_wallet_withdraw")
     * @Template("AdminWalletBundle::withdraw.html.twig")
     */
    public function withdrawAction()
    {
        $source = new Entity('\StatisticBundle\Entity\WalletStatistic');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.type = false');
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'hash',
        ));

        $user = new TextColumn(array(
            'id'    => 'username',
            'field' => 'user.username',
            'source'    => true,
            'title' => 'User',
        ));
        $grid->addColumn($user, 1);

        $statusColumn = new StatusColumn(array(
            'id'        => 'status',
            'title'     => 'status',
        ));
        $grid->addColumn($statusColumn);

        $waitAction = new MassAction('Ожидание', 'Admin\WalletBundle\Controller\WalletController::waitAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($waitAction);

        $doneAction = new MassAction('Выплачено', 'Admin\WalletBundle\Controller\WalletController::doneAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($doneAction);

        $refundAction = new MassAction('Возврат', 'Admin\WalletBundle\Controller\WalletController::refundAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($refundAction);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function waitAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user WalletStatistic */
            $transaction = $em->getRepository('StatisticBundle:WalletStatistic')->find($id);
            $transaction->setStatus(0);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function doneAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user WalletStatistic */
            $transaction = $em->getRepository('StatisticBundle:WalletStatistic')->find($id);
            $transaction->setStatus(1);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function refundAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user WalletStatistic */
            $transaction = $em->getRepository('StatisticBundle:WalletStatistic')->find($id);
            $transaction->setStatus(2);

            $user = $transaction->getUser();
            $typeWallet = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                'name'  => 'M',
            ));

            $userWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                'type'  => $typeWallet,
                'user'  => $user,
            ));

            $userWallet->setSum($userWallet->getSum() + ($transaction->getSum() + $transaction->getSum() * 1.5 / 100));

            $em->flush();
        }
    }
}
