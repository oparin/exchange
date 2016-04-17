<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 10.02.16
 * Time: 19:11
 */

namespace WalletBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class DepositController
 * @package WalletBundle\Controller
 */
class DepositController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/deposit", name="office_deposit")
     * @Template("WalletBundle:Deposit:deposit.html.twig")
     */
    public function depositAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('sum', 'number', array(
                'constraints' => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum = $form->get('sum')->getData();
                if ($sum >= 5) {
                    $this->get('session')->set('sum', $sum);

                    return $this->redirectToRoute('office_choice_payment');
                } else {
                    $this->addFlash(
                        'error',
                        'Minimum amount = 5$'
                    );
                }
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @return array
     *
     * @Route("/deposit-statistic", name="office_deposit_statistic")
     * @Template("WalletBundle:Deposit:deposit_statistic.html.twig")
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
                    ->andWhere($tableAlias.'.type = true')
                    ->andWhere($tableAlias.'.status = 1')
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
