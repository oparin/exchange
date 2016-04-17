<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/13/15
 * Time: 9:19 AM
 */

namespace Admin\MemberBundle\Controller;

require_once('../../src/UserBundle/Entity/User.php');

use Admin\MemberBundle\Form\Type\MemberFormType;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\BooleanColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\User;

/**
 * Class MembersController
 * @package Admin\MemberBundle\Controller
 */
class MembersController extends Controller
{
    /**
     * @return array
     *
     * @Route("/members", name="admin_members_all_members")
     */
    public function membersAction()
    {
        $source = new Entity('\UserBundle\Entity\User');
        $grid = $this->get('grid');

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'usernameCanonical',
            'emailCanonical',
            'salt',
            'password',
            'confirmationToken',
            'passwordRequestedAt',
            'expired',
            'expiresAt',
            'credentialsExpired',
            'credentialsExpired',
            'credentialsExpireAt',
            'roles',
            'locked',
            'lastLogin',
//            'enabled',
            'registrationBonus',
            'rating',
            'miningRights',
            'miningRightsInWork',
            'poolWallet',
            'countMultiply',
        ));

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('usernameCanonical')->setFilterable(false);
        $grid->getColumn('emailCanonical')->setFilterable(false);
        $grid->getColumn('enabled')->setFilterable(false);
        $grid->getColumn('salt')->setFilterable(false);
        $grid->getColumn('password')->setFilterable(false);
        $grid->getColumn('lastLogin')->setFilterable(false);
        $grid->getColumn('confirmationToken')->setFilterable(false);
        $grid->getColumn('passwordRequestedAt')->setFilterable(false);
        $grid->getColumn('locked')->setFilterable(false);
        $grid->getColumn('expired')->setFilterable(false);
        $grid->getColumn('expiresAt')->setFilterable(false);
        $grid->getColumn('roles')->setFilterable(false);
        $grid->getColumn('credentialsExpired')->setFilterable(false);
        $grid->getColumn('credentialsExpireAt')->setFilterable(false);
        $grid->getColumn('registrationDate')->setFilterable(false);
        $grid->getColumn('registrationBonus')->setFilterable(false);
        $grid->getColumn('miningRights')->setFilterable(false);
        $grid->getColumn('miningRightsInWork')->setFilterable(false);
        $grid->getColumn('poolWallet')->setFilterable(false);
        $grid->getColumn('countMultiply')->setFilterable(false);

        $grid->getColumn('username')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('email')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('registerIp')->setTitle('Register Ip')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('lastIp')->setTitle('Last Ip')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('rating')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);

        $sponsor    = new TextColumn(array(
            'id'    => 'sponsor',
            'field' => 'sponsor.username',
            'title' => 'Спонсор',
            'source'    => true,
            'align' => 'center',
        ));
        $sponsor->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->addColumn($sponsor, 3);

        $grid->getColumn('username')->setTitle('Логин');
        $grid->getColumn('email')->setTitle('Email');
        $grid->getColumn('registerIp')->setTitle('Ip Регистрации');
        $grid->getColumn('lastIp')->setTitle('Последний Ip');
        $grid->getColumn('registrationDate')->setTitle('Дата Регистрации');
        $grid->getColumn('rating')->setTitle('Рейтинг');
        $grid->getColumn('enabled')->setTitle('Активация');

        $editAction = new RowAction('edit', 'admin_members_edit_member');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

        $loginAction = new RowAction('login', 'admin_user_login');
        $loginAction->setRouteParameters(array('id'));
        $loginAction->setTarget('_blank');
        $grid->addRowAction($loginAction);

        $activateAction = new MassAction('Активировать', 'Admin\MemberBundle\Controller\MembersController::ActivateAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($activateAction);

        $grid->setDefaultOrder('id', 'DESC');

        return $grid->getGridResponse('AdminMemberBundle::members.html.twig');
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function activateAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user User */
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setEnabled(true);
            $em->flush();
        }
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return array
     *
     * @Route("/member/{id}", name="admin_members_edit_member")
     * @Template("AdminMemberBundle::member.html.twig")
     */
    public function editUserAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em     = $this->getDoctrine()->getManager();

        $member = $em->getRepository('UserBundle:User')->find($id);

        if (!$member) {
            throw new NotFoundHttpException('Not Found!');
        }

        $form   = $this->createForm(new MemberFormType(), $member, array(
            'em' => $em,
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                $this->redirectToRoute('admin_members_edit_member', array('id'  => $id));
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return array
     *
     * @Route("/user-login/{id}", name="admin_user_login")
     */
    public function loginUserAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AdminSettingsBundle:Settings')->find(1);

        return $this->redirect($settings->getSiteName().'/abrakadabra-secret-login-user/'.$id);
    }
}
