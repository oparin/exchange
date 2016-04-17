<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 3:26 PM
 */

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class UserController
 * @package UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @param int $id
     *
     * @return array
     *
     * @Route("/abrakadabra-secret-login-user/{id}", name="admin_user_login")
     */
    public function userLoginAction($id)
    {
        /* @var $em EntityManager  */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
            $this->get("security.token_storage")->setToken($token); //now the user is logged in

        }

        return $this->redirectToRoute('fos_user_profile_show');
    }
}