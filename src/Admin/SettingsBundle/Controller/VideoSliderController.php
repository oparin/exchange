<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12.02.16
 * Time: 18:38
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Entity\VideoSlide;
use Admin\SettingsBundle\Form\Type\VideoSlideFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VideoSliderController
 * @package Admin\SettingsBundle\Controller
 */
class VideoSliderController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/video-slide/{id}", name="admin_video_slide")
     * @Template("AdminSettingsBundle:VideoSlide:edit_slide.html.twig")
     */
    public function editVideoSliderAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $file = ($id) ? $em->getRepository('AdminSettingsBundle:VideoSlide')->find($id) : null;

        $form = $this->createForm(new VideoSlideFormType(), $file);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var $data VideoSlide */
                $data = $form->getData();

                $em->persist($data);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirectToRoute('admin_video_slide');
            }
        }

        return array(
            'form'  => $form->createView(),
            'files' => $em->getRepository('AdminSettingsBundle:VideoSlide')->findAll(),
        );
    }
}
