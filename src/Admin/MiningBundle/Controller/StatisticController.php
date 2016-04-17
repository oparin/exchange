<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 07.04.16
 * Time: 10:20
 */

namespace Admin\MiningBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class StatisticController
 * @package Admin\MiningBundle\Controller
 */
class StatisticController extends Controller
{
    /**
     * @return array
     *
     * @Route("/statistic", name="mining_statistic")
     * @Template("AdminMiningBundle:Statistic:statistic.html.twig")
     */
    public function calculateAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(u.miningRights)');
        $miningRights = $qb->getQuery()->getSingleScalarResult();


        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(u.miningRightsInWork)');
        $miningRightsInWork = $qb->getQuery()->getSingleScalarResult();


        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(u.poolWallet)');
        $poolWallet = $qb->getQuery()->getSingleScalarResult();


        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(a.sum)')
            ->leftJoin('u.accounts', 'a')
            ->leftJoin('a.type', 't')
            ->where("t.name = 'M'");
        $mainAccount = $qb->getQuery()->getSingleScalarResult();


        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(a.sum)')
            ->leftJoin('u.currency', 'a')
            ->leftJoin('a.type', 't')
            ->where("t.name = 'M'");
        $mainEthAccount = $qb->getQuery()->getSingleScalarResult();


        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('SUM(a.sum)')
            ->leftJoin('u.wallets', 'a')
            ->leftJoin('a.type', 't')
            ->where("t.name = 'M'");
        $mainWallet = $qb->getQuery()->getSingleScalarResult();

        return array(
            'mining_rights'         => $miningRights,
            'mining_rights_in_work' => $miningRightsInWork,
            'pool_wallet'           => $poolWallet,
            'main_account'          => $mainAccount,
            'main_eth_account'      => $mainEthAccount,
            'main_wallet'           => $mainWallet,
        );
    }
}
