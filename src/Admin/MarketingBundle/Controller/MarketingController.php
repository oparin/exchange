<?php

namespace Admin\MarketingBundle\Controller;

use Admin\MarketingBundle\Form\Type\BinaryProfitFormType;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\PointsStatistic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MarketingController
 * @package Admin\MarketingBundle\Controller
 */
class MarketingController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/calculate-points", name="marketing_calculate_points")
     * @Template("AdminMarketingBundle::calculate_points.html.twig")
     */
    public function calculatePointsAction(Request $request)
    {
        $form = $this->createFormBuilder()->getForm();

        if ($request->isMethod('POST')) {
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            $users = $em->getRepository('UserBundle:User')->findAll();

            /* @var $user \UserBundle\Entity\User */
            foreach ($users as $user) {
                if ($user->getBinary()) {
                    if ($user->getBinary()->getLeftPoints() != 0 && $user->getBinary()->getRightPoints() != 0) {
                        $referrals = $em->getRepository('UserBundle:User')->getCountReferrals($user);
//                    if ($referrals >= 2) {
                        if ($user->getStatus()) {
                            $leftPoints = $user->getBinary()->getLeftPoints();
                            $rightPoints = $user->getBinary()->getRightPoints();
                            $accountType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(
                                array(
                                    'name' => 'M',
                                )
                            );
                            $wallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(
                                array(
                                    'type' => $accountType,
                                    'user' => $user,
                                )
                            );
                            if ($leftPoints < $rightPoints) {
                                $difference = $rightPoints - $leftPoints;
                                $bonus = $leftPoints * $user->getStatus()->getPercent() / 100;
                                $statistic = new PointsStatistic();
                                $statistic->setUser($user);
                                $statistic->setRightPoints($rightPoints);
                                $statistic->setLeftPoints($leftPoints);
                                $statistic->setDate(new \DateTime());
                                $statistic->setBonus($bonus);
                                $em->persist($statistic);

                                $user->getBinary()->setRightPoints($difference);
                                $user->getBinary()->setLeftPoints(0);
                            } elseif ($leftPoints > $rightPoints) {
                                $difference = $leftPoints - $rightPoints;
                                $bonus = $rightPoints * $user->getStatus()->getPercent() / 100;
                                $statistic = new PointsStatistic();
                                $statistic->setUser($user);
                                $statistic->setRightPoints($rightPoints);
                                $statistic->setLeftPoints($leftPoints);
                                $statistic->setDate(new \DateTime());
                                $statistic->setBonus($bonus);
                                $em->persist($statistic);

                                $user->getBinary()->setRightPoints(0);
                                $user->getBinary()->setLeftPoints($difference);
                            } elseif ($leftPoints == $rightPoints) {
                                $bonus = $rightPoints * $user->getStatus()->getPercent() / 100;
                                $statistic = new PointsStatistic();
                                $statistic->setUser($user);
                                $statistic->setRightPoints($rightPoints);
                                $statistic->setLeftPoints($leftPoints);
                                $statistic->setDate(new \DateTime());
                                $statistic->setBonus($bonus);
                                $em->persist($statistic);

                                $user->getBinary()->setRightPoints(0);
                                $user->getBinary()->setLeftPoints(0);
                            }
                            $wallet->setSum($wallet->getSum() + $bonus);
                        }
                    }
                }
            }

            $em->flush();

            $this->addFlash(
                'success',
                'Выполнено!'
            );

            return $this->redirectToRoute('marketing_calculate_points');
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/settings-profit/{id}", name="marketing_settings_profit")
     * @Template("AdminMarketingBundle::settings_profit.html.twig")
     */
    public function settingsProfitAction(Request $request, $id = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();

        $profits = $em->getRepository('AdminMarketingBundle:BinaryProfit')->findAll();

        $profit = ($id) ? $profit = $em->getRepository('AdminMarketingBundle:BinaryProfit')->find($id) : null;

        $form = $this->createForm(new BinaryProfitFormType(), $profit);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            /* @var $data \Admin\MarketingBundle\Entity\BinaryProfit */
            $data = $form->getData();

            $exist = $em->getRepository('AdminMarketingBundle:BinaryProfit')->findOneBy(array(
                'statusFrom'   => $data->getStatusFrom(),
                'statusTo'     => $data->getStatusTo(),
            ));

            if ($exist && !$id) {
                $form->addError(new FormError('Уже существует!'));
            }

            if ($form->isValid()) {
                $em->persist($data);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Сохранено!'
                );

                return $this->redirect($this->generateUrl('marketing_settings_profit'));
            }
        }

        return array(
            'profits'   => $profits,
            'form'      => $form->createView(),
        );
    }
}
