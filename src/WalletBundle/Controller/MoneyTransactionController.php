<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/25/16
 * Time: 10:30 AM
 */

namespace WalletBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;

/**
 * Class MoneyTransactionController
 * @package WalletBundle\Controller
 */
class MoneyTransactionController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/money-transaction", name="office_money_transaction")
     * @Template("WalletBundle:MoneyTransaction:money_transaction.html.twig")
     */
    public function moneyTransactionAction(Request $request)
    {
        /** @var $user User */
        $user = $this->getUser();

        $form = $this->createFormBuilder()
            ->add('wallet', 'choice', array(
                'choices'   => array(
                    'M' => 'money_transaction.main_wallet',
//                    'B' => 'money_transaction.bonus_wallet',
                ),
                'constraints'   => array(new NotBlank()),
            ))
            ->add('sum', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $type   = $form->get('wallet')->getData();
                $sum    = $form->get('sum')->getData();

                /** @var $em EntityManager */
                $em = $this->getDoctrine()->getManager();
                $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                    'name'  => $type,
                ));

                if ($typeBalance) {
                    $wallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $typeBalance,
                    ));

                    if ($wallet->getSum() < $sum) {
                        $this->addFlash(
                            'error',
                            $this->get('translator')->trans('money_transaction.no_funds')
                        );
                    } else {
                        $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                            'name'  => 'M',
                        ));
                        $account = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                            'user'  => $user,
                            'type'  => $typeBalance,
                        ));

                        $wallet->setSum($wallet->getSum() - $sum);
                        $account->setSum($account->getSum() + $sum);

                        $em->flush();

                        $this->addFlash(
                            'success',
                            $this->get('translator')->trans('money_transaction.transfer_success')
                        );

                        return $this->redirectToRoute('office_dashboard');
                    }
                }
            }
        }

        return array(
            'form'      => $form->createView(),
            'wallets'   => $user->getWallets(),
        );
    }
}
