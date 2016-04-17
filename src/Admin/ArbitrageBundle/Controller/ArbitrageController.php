<?php

namespace Admin\ArbitrageBundle\Controller;

use Admin\ArbitrageBundle\Grid\Column\ArbitrageStatusColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ArbitrageController
 * @package Admin\ArbitrageBundle\Controller
 */
class ArbitrageController extends Controller
{
    /**
     * @return array
     *
     * @Route("/all-loans", name="arbitrage_all_loans")
     */
    public function indexAction()
    {
        $source = new Entity('\OfficeBundle\Entity\ArbitrageCredit');
        $grid = $this->get('grid');

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'status',
        ));

        $grid->setDefaultOrder('id', 'DESC');

        $user = new TextColumn(array(
            'id'    => 'user',
            'field' => 'user.username',
            'title' => 'Пользователь',
            'source'    => true,
        ));
        $user->setAlign('center');
        $grid->addColumn($user, 1);

        $grid->getColumn('sum')->setTitle('Сумма')->setAlign('center');
        $grid->getColumn('multiplier')->setTitle('Множитель')->setAlign('center');
        $grid->getColumn('days')->setTitle('Дни')->setAlign('center');
        $grid->getColumn('percent')->setTitle('Процент')->setAlign('center');
        $grid
            ->getColumn('dateStart')
            ->setTitle('Дата')
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    /** @var  $row Row */
                    $date    = $row->getField('dateStart');

                    return $date->format('d/m/Y h:i');
                }
            );

        $grid->getColumn('returnSum')->setTitle('Сумма Возвр')->setAlign('center');
        $grid->getColumn('prolongation')->setTitle('Пролонгация')->setAlign('center');

        $grid
            ->getColumn('dateEnd')
            ->setTitle('Дата погашения')
            ->setAlign('center')
            ->manipulateRenderCell(
                function ($value, $row, $router) {
                    /** @var  $row Row */
                    $date    = $row->getField('dateEnd');

                    return $date->format('d/m/Y h:i');
                }
            );

        $status = new ArbitrageStatusColumn(array(
            'id'    => 'Status',
            'title' => 'Статус',
        ));
        $status->manipulateRenderCell(
            function ($value, $row, $router) {
                /** @var  $row Row */
                $status    = $row->getField('status');

                return $status;
            }
        )->setAlign('center');
        $grid->addColumn($status);



        return $grid->getGridResponse('AdminArbitrageBundle::all_loans.html.twig');
    }
}
