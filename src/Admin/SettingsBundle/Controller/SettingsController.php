<?php

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\GeneralSettingsFormType;
use Admin\SettingsBundle\Form\Type\RegistrationBonusSettingsFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SettingsController
 * @package Admin\SettingsBundle\Controller
 */
class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/general-settings", name="admin_settings_general_settings")
     * @Template("AdminSettingsBundle::general_settings.html.twig")
     */
    public function generalSettingsAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AdminSettingsBundle:Settings')->find(1);

        $form = $this->createForm(new GeneralSettingsFormType(), $settings);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->flush($data);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirectToRoute('admin_settings_general_settings');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
