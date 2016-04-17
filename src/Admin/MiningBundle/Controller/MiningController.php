<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 06.04.16
 * Time: 16:36
 */

namespace Admin\MiningBundle\Controller;

use Admin\MiningBundle\Entity\SplitStatistic;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Class MiningController
 * @package Admin\MiningBundle\Controller
 */
class MiningController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/calculate", name="mining_calculate")
     * @Template("AdminMiningBundle:Calculate:calculate.html.twig")
     */
    public function calculateAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
            $qb
                ->where('u.miningRights > 0')
                ->andWhere('u.countMultiply < 2');
            $users = $qb->getQuery()->getResult();

            $count = 0;
            if ($users) {
                /** @var $user User */
                foreach ($users as $user) {
                    if ($user->getStatus()->getId() < 4) {
                        if ($user->getCountMultiply() < 1) {
                            $user->setMiningRights($user->getMiningRights() * 2);
                            $user->setCountMultiply($user->getCountMultiply() + 1);
                            $count++;
                        }
                    } else {
                        if ($user->getCountMultiply() < 2) {
                            $user->setMiningRights($user->getMiningRights() * 2);
                            $user->setCountMultiply($user->getCountMultiply() + 1);
                            $count++;
                        }
                    }
                }
            }

            $statistic = new SplitStatistic();
            $statistic->setDate(new \DateTime());
            $em->persist($statistic);

            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Success! Users - '.$count
            );

            $this->redirectToRoute('mining_calculate');
        }

        return array();
    }
}
