<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class HomeController
 * @package HomeBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @return array
     *
     * @Route("/", name="home_index")
     * @Template("HomeBundle::index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'home',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/about", name="home_about")
     * @Template("HomeBundle::about.html.twig")
     */
    public function aboutAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'about',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/founders", name="home_services")
     * @Template("HomeBundle::services.html.twig")
     */
    public function servicesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'services',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/mining", name="home_pages")
     * @Template("HomeBundle::pages.html.twig")
     */
    public function pagesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'pages',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/video-gallery", name="home_blog")
     * @Template("HomeBundle::blog.html.twig")
     */
    public function blogAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'blog',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/affiliate-program", name="affiliate_program")
     * @Template("HomeBundle::affiliate_program.html.twig")
     */
    public function affiliateProgramAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'affiliate_program',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/mining-pool", name="mining_pool")
     * @Template("HomeBundle::mining_pool.html.twig")
     */
    public function miningPoolAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'mining_pool',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/contact", name="home_contact")
     * @Template("HomeBundle::contact.html.twig")
     */
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'contact',
            'locale'    => $request->getLocale(),
        ));

        $form = $this->createFormBuilder()
            ->add('name', 'text', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('email', 'email', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('theme', 'choice', array(
                'choices'   => array(
                    'General support'       => 'General support',
                    'Project Discussion'    => 'Project Discussion',
                    'Other'                 => 'Other',
                ),
            ))
            ->add('message', 'textarea', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $captcha = $_POST['g-recaptcha-response'];
//                $result = file_get_contents('www.google.com/recaptcha/api/siteverify?secret=6LeHkBkTAAAAAC611CPnLQKJyqwDeaJ1hFuEhfl9&response='.$captcha);
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query(array(
                        'secret'    => '6LeHkBkTAAAAAC611CPnLQKJyqwDeaJ1hFuEhfl9',
                        'response'  => $captcha,
                    ))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $result = json_decode($response);
                if ($result->success) {
                    $name = $form->get('name')->getData();
                    $email = $form->get('email')->getData();
                    $theme = $form->get('theme')->getData();
                    $message = $form->get('message')->getData();

                    $message = \Swift_Message::newInstance()
                        ->setSubject($theme)
                        ->setFrom($email)
                        ->setTo('admin@ethereumpro.org')
                        ->setBody(
                            $this->renderView(
                                ':home/Emails:contact.html.twig',
                                array('message' => $message)
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);
                    $this->addFlash('success', 'Message sent!');

                    return $this->redirectToRoute('home_contact');
                } else {
                    $this->addFlash('error', 'Invalid Captcha!');
                }
            }
        }

        return array(
            'form'  => $form->createView(),
            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/terms-and-conditions", name="home_terms_and_conditions")
     * @Template("HomeBundle::terms_and_conditions.html.twig")
     */
    public function termsAndConditionsAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $request = $this->get('request');
//        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
//            'title' => 'blog',
//            'locale'    => $request->getLocale(),
//        ));

        return array(
//            'page'  => $page,
        );
    }

    /**
     * @return array
     *
     * @Route("/privacy", name="home_privacy")
     * @Template("HomeBundle::privacy.html.twig")
     */
    public function privacyAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $request = $this->get('request');
//        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
//            'title' => 'blog',
//            'locale'    => $request->getLocale(),
//        ));

        return array(
//            'page'  => $page,
        );
    }
}
