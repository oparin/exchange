<?php

namespace Admin\NewsBundle\Controller;

use Admin\NewsBundle\Entity\News;
use Admin\NewsBundle\Form\Type\NewsFormType;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NewsController
 * @package Admin\NewsBundle\Controller
 */
class NewsController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/all-news", name="admin_all_news")
     */
    public function allNewsAction()
    {
        $source = new Entity('AdminNewsBundle:News');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(
            array(
                'id',
                'titleEn',
                'text',
                'textEn',
            )
        );

        $editAction = new RowAction('edit', 'admin_news');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

        $massAction = new DeleteMassAction(true);
        $massAction->setConfirm(true);
        $grid->addMassAction($massAction);

        $grid->setDefaultOrder('id', 'DESC');

        return $grid->getGridResponse('AdminNewsBundle::all_news.html.twig');
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/news/{id}", name="admin_news")
     * @Template("AdminNewsBundle::news.html.twig")
     */
    public function editNewsAction(Request $request, $id = null)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $news = $em->getRepository('AdminNewsBundle:News')->find($id);
        } else {
            $news = new News();
        }
        $form = $this->createForm(new NewsFormType(), $news);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $data->setDate(new \DateTime());

                $em->persist($data);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirect($this->generateUrl('admin_news', array('id' => $id)));
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
