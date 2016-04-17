<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.02.16
 * Time: 9:51
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\ReferralBonusFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReferralBonusController
 * @package Admin\SettingsBundle\Controller
 */
class ReferralBonusController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/referral-bonus/{id}", name="referral_bonus_settings")
     * @Template("AdminSettingsBundle:ReferralBonus:referral_bonus_settings.html.twig")
     */
    public function referralBonusSettingsAction(Request $request, $id = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();

        $profits = $em->getRepository('AdminSettingsBundle:ReferralBonus')->findAll();

        $profit = ($id) ? $profit = $em->getRepository('AdminSettingsBundle:ReferralBonus')->find($id) : null;

        $form = $this->createForm(new ReferralBonusFormType(), $profit);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            /* @var $data \Admin\MarketingBundle\Entity\BinaryProfit */
            $data = $form->getData();

            $exist = $em->getRepository('AdminSettingsBundle:ReferralBonus')->findOneBy(array(
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

                return $this->redirect($this->generateUrl('referral_bonus_settings'));
            }
        }

        return array(
            'profits'   => $profits,
            'form'      => $form->createView(),
        );
    }
}
