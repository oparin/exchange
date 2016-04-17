<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/13/16
 * Time: 12:46 PM
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\FaqFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FaqController
 * @package Admin\SettingsBundle\Controller
 */
class FaqController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/faq-settings/{id}", name="settings_faq")
     * @Template("AdminSettingsBundle:Faq:faq_edit.html.twig")
     */
    public function faqEditAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $faq = ($id) ? $em->getRepository('AdminSettingsBundle:Faq')->find($id) : null;

        $form = $this->createForm(new FaqFormType(), $faq);

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

                if ($id) {
                    return $this->redirectToRoute('settings_faq', array('id' => $id));
                } else {
                    return $this->redirectToRoute('all_faq');
                }
            }
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * @return array
     *
     * @Route("/all-faq", name="all_faq")
     * @Template("AdminSettingsBundle:Faq:all_faq.html.twig")
     */
    public function allFaqAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $faqs = $em->getRepository('AdminSettingsBundle:Faq')->findAll();

        return array(
            'faqs' => $faqs,
        );
    }

    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/faq-delete/{id}", name="delete_faq")
     */
    public function faqDeleteAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $faq = $em->getRepository('AdminSettingsBundle:Faq')->find($id);

        $em->remove($faq);
        $em->flush();

        return $this->redirectToRoute('all_faq');
    }
}
