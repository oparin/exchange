<?php

namespace Admin\StaticPageBundle\Controller;

use Admin\StaticPageBundle\Form\Type\StaticPageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class StaticPageController extends Controller
{
    /**
     * @Route("/static-page/{id}", name="admin_static_page")
     * @Template("AdminStaticPageBundle::static_page.html.twig")
     */
    public function staticPageAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->find($id);

        $form = $this->createForm(new StaticPageFormType(), $page);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $em->persist($data);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirect($this->generateUrl('admin_static_page', array('id' => $id)));
            }
        }

        return array(
            'page' => $page,
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/all-static-page", name="admin_all_static_page")
     * @Template("AdminStaticPageBundle::all_static_page.html.twig")
     */
    public function allStaticPageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AdminStaticPageBundle:StaticPage')->findAll();

        return array(
            'pages' => $pages,
        );
    }
}
