<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/30/15
 * Time: 5:17 PM
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\MemberStatusFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusController
 * @package Admin\SettingsBundle\Controller
 */
class StatusController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/member-status-settings/{id}", name="admin_settings_members_status_settings")
     * @Template("AdminSettingsBundle:Status:status_settings.html.twig")
     */
    public function generalSettingsAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if (!$id) {
            $status = null;
        } else {
            $status = $em->getRepository('AdminSettingsBundle:MemberStatus')->find($id);
        }

        $form = $this->createForm(new MemberStatusFormType(), $status);

        $statuses = $em->getRepository('AdminSettingsBundle:MemberStatus')->findBy(array(), array('id' => 'ASC'));

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

                return $this->redirectToRoute('admin_settings_members_status_settings');
            } else {
                dump($form->getErrors());exit;
            }
        }

        return array(
            'form'      => $form->createView(),
            'statuses'  => $statuses,
            'status'    => $status,
        );
    }

    /**
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/member-status-delete/{id}", name="admin_settings_members_status_delete")
     */
    public function memberStatusDeleteAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('AdminSettingsBundle:MemberStatus')->find($id);
        $em->remove($status);
        $em->flush($status);

        $this->get('session')->getFlashBag()->add(
            'success',
            'Success!'
        );

        return $this->redirectToRoute('admin_settings_members_status_settings');
    }
}
