<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.02.2016
 * Time: 11:38
 */

namespace OfficeBundle\Controller;

use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class ReferralController
 * @package OfficeBundle\Controller
 */
class ReferralController extends Controller
{
    /**
     * @return array
     *
     * @Route("/referrals-my-referrals", name="referrals_my_referrals")
     * @Template("OfficeBundle:Referrals:my_referrals.html.twig")
     */
    public function myReferralsAction()
    {
        $source = new Entity('UserBundle:User');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.sponsor = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'usernameCanonical',
            'emailCanonical',
            'enabled',
            'salt',
            'password',
            'confirmationToken',
            'passwordRequestedAt',
            'locked',
            'expired',
            'expiresAt',
            'roles',
            'credentialsExpired',
            'credentialsExpireAt',
            'registrationBonus',
            'rating',
            'lastIp',
            'registerIp',
            'miningRights',
            'miningRightsInWork',
            'poolWallet',
            'countMultiply',

        ));

        $translator = $this->get('translator');

        $grid->getColumn('email')->setTitle('Email');
        $grid->getColumn('username')->setTitle($translator->trans('referrals.username'));
        $grid->getColumn('lastLogin')->setTitle($translator->trans('referrals.lastLogin'));
        $grid->getColumn('registrationDate')->setTitle($translator->trans('referrals.registrationDate'));

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
     * @Route("/referrals-statistic", name="referrals_statistic")
     * @Template("OfficeBundle:Referrals:statistic.html.twig")
     */
    public function referralsStatisticAction()
    {
        $source = new Entity('StatisticBundle:SponsorBonusStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->leftJoin($tableAlias.'.user', 's')
                    ->andWhere('s.sponsor = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $translator = $this->get('translator');

        $sponsor = new TextColumn(array(
            'id'        => 'sponsor',
            'field'     => 'user.username',
            'source'    => true,
            'title'     => $translator->trans('referrals.username'),
        ));
        $grid->addColumn($sponsor, 1);

        $grid->getColumn('date')->setTitle($translator->trans('referrals.date'));
        $grid->getColumn('bonus')->setTitle($translator->trans('referrals.bonus'));

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}