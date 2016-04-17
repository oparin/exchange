<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/2/15
 * Time: 11:11 AM
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\ProjectStatisticFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectStatisticController
 * @package Admin\SettingsBundle\Controller
 */
class ProjectStatisticController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/project-statistic-settings/{id}", name="admin_settings_project_statistic_settings")
     * @Template("AdminSettingsBundle:ProjectStatistic:project_statistic_settings.html.twig")
     */
    public function projectStatisticController(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $statistics = $em->getRepository('AdminSettingsBundle:ProjectStatistic')->findBy(array(), array('id' => 'DESC'));

        if (!$id) {
            $statistic = null;
        } else {
            $statistic = $em->getRepository('AdminSettingsBundle:ProjectStatistic')->find($id);
        }

        $form = $this->createForm(new ProjectStatisticFormType(), $statistic);

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

                return $this->redirectToRoute('admin_settings_project_statistic_settings');
            }
        }

        return array(
            'form'          => $form->createView(),
            'statistics'    => $statistics,
        );
    }
}
