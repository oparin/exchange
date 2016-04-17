<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 07.04.16
 * Time: 11:18
 */

namespace OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class LocaleController
 * @package OfficeBundle\Controller
 */
class LocaleController extends Controller
{
    /**
     * @param Request $request
     * @param string  $locale
     * @return RedirectResponse
     *
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocaleAction(Request $request, $locale = 'ru')
    {
        $referer  = $request->headers->get('referer');
        $response = new RedirectResponse($referer);
        $response->headers->setCookie(new Cookie('locale', $locale, time() + (30 * 24 * 60 * 60)));

        return $response;
    }
}
