<?php

namespace Admin\MiningBundle\Controller;

use Admin\MiningBundle\Form\Type\SettingsFormType;
use Admin\MiningBundle\Form\Type\SettingsRatesFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/settings/rates", name="mining_settings_rates")
     * @Template("AdminMiningBundle:Settings:rates.html.twig")
     */
    public function settingsRatesAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new SettingsRatesFormType(), $em->getRepository('AdminMiningBundle:Rate')->findOneBy(array()));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush($data);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirectToRoute('mining_settings_rates');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/settings/settings", name="mining_settings_settings")
     * @Template("AdminMiningBundle:Settings:settings.html.twig")
     */
    public function settingsAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new SettingsFormType(), $em->getRepository('AdminMiningBundle:Settings')->findOneBy(array()));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush($data);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirectToRoute('mining_settings_settings');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
