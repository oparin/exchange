<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 2:23 PM
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\ArbitrageSettingsFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArbitrageController
 * @package Admin\SettingsBundle\Controller
 */
class ArbitrageController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/arbitrage-settings", name="settings_arbitrage_settings")
     * @Template("AdminSettingsBundle:Arbitrage:arbitrage_settings.html.twig")
     */
    public function generalSettingsAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $form   = $this->createForm(new ArbitrageSettingsFormType(), $em->getRepository('AdminSettingsBundle:ArbitrageSettings')->find(1));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->flush($data);

                $this->addFlash(
                    'success',
                    'Сохранено!'
                );

                return $this->redirectToRoute('settings_arbitrage_settings');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
