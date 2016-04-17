<?php

namespace StatisticBundle\Controller;

use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use StatisticBundle\Grid\Column\TransactionColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class TransactionController
 * @package StatisticBundle\Controller
 */
class TransactionController extends Controller
{
    /**
     * @return array
     *
     * @Route("/transaction", name="office_transaction")
     * @Template("StatisticBundle:Transaction:transaction.html.twig")
     */
    public function transactionAction()
    {
        $source = new Entity('StatisticBundle:TransactionStatistic');
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
            'bonusWallet',
            'bonusAccount',
            'bonusEthereum',
        ));

        $translator = $this->get('translator');

        $grid->getColumn('date')->setTitle($translator->trans('transaction.date'));
        $grid->getColumn('sum')->setTitle($translator->trans('transaction.sum'));
        $grid->getColumn('mainWallet')->setTitle($translator->trans('transaction.mainWallet'));
        $grid->getColumn('bonusWallet')->setTitle($translator->trans('transaction.bonusWallet'));
        $grid->getColumn('mainAccount')->setTitle($translator->trans('transaction.mainAccount'));
        $grid->getColumn('bonusAccount')->setTitle($translator->trans('transaction.bonusAccount'));
        $grid->getColumn('type')->setTitle($translator->trans('transaction.transaction'));
        $grid->getColumn('mainEthereum')->setTitle($translator->trans('transaction.mainEthereum'));
        $grid->getColumn('bonusEthereum')->setTitle($translator->trans('transaction.bonusEthereum'));

        $grid->getColumn('type')->manipulateRenderCell(
            function($value, $row, $router) use ($translator) {
                /* @var $row Row */
                if ($row->getField('type') == 0) {
                    $result = $translator->trans('transaction.withdraw');
                } elseif ($row->getField('type') == 1) {
                    $result = $translator->trans('transaction.add_funds');
                } elseif ($row->getField('type') == 2) {
                    $result = $translator->trans('transaction.buy_status');
                } elseif ($row->getField('type') == 3) {
                    $result = $translator->trans('transaction.sale_bid');
                } elseif ($row->getField('type') == 4) {
                    $result = $translator->trans('transaction.buy_bid');
                } elseif ($row->getField('type') == 5) {
                    $result = $translator->trans('transaction.delete_sale_bid');
                } elseif ($row->getField('type') == 6) {
                    $result = $translator->trans('transaction.delete_buy_bid');
                }


                return $result;
            }
        )->setAlign('center');


        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}
