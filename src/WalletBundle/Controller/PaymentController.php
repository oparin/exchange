<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11.02.16
 * Time: 15:44
 */

namespace WalletBundle\Controller;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use WalletBundle\Event\WalletEvent;
use WalletBundle\WalletEvents;

/**
 * Class PaymentController
 * @package WalletBundle\Controller
 */
class PaymentController extends Controller
{
    /**
     * @return array
     *
     * @Route("/choice-payment", name="office_choice_payment")
     * @Template("WalletBundle:Payment:choice_payment.html.twig")
     */
    public function choicePaymentAction()
    {
        $session    = $this->get('session');
        $sum        = $session->get('sum');
        $payeerSum  = number_format($sum, 2, '.', '');

        /** @var $user User */
        $user = $this->getUser();
        $name = 'EthereumPro';

        // Advanced cash
        $id = time();
        $acPassword = $this->get('service_container')->getParameter('adv_password');
        $hash = hash('sha256', $this->get('service_container')->getParameter('adv_acc_email').':'.$name.':'.$sum.':'.$this->get('service_container')->getParameter('adv_currency').':'.$acPassword.':'.$id);

        // Payeer
        $shop       = $this->get('service_container')->getParameter('payeer_id');
        $orderId    = $this->getUser()->getId();
        $curr       = $this->get('service_container')->getParameter('payeer_currency');
        $desc       = base64_encode('Add funds');
        $secret     = $this->get('service_container')->getParameter('payeer_secret');

//        dump($shop);
//        dump($orderId);
//        dump($curr);
//        dump($desc);
//        dump($secret);

        $arHash = array(
            $shop,
            $orderId,
            $payeerSum,
            $curr,
            $desc,
            $secret,
        );
        $sign = strtoupper(hash('sha256', implode(":", $arHash)));
//        dump($sign);exit;
        return array(
            'account'   => $this->get('service_container')->getParameter('pm_account'),
            'currency'  => $this->get('service_container')->getParameter('pm_currency'),

            'account_email' => $this->get('service_container')->getParameter('adv_acc_email'),
            'ac_currency' => $this->get('service_container')->getParameter('adv_currency'),

            'sum'       => $sum,
            'name'      => $name,
            'hash'      => $hash,
            'id'        => $id,

            'm_shop'    => $shop,
            'm_orderid' => $orderId,
            'm_amount'  => $sum,
            'm_curr'    => $curr,
            'm_desc'    => $desc,
            'm_sign'    => $sign,
        );
    }

    /**
     * @return array
     *
     * @Route("/ethereum-payment", name="office_payment_ethereum")
     * @Template("WalletBundle:Payment:ethereum_payment.html.twig")
     */
    public function ethereumPaymentAction()
    {
        return array();
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/perfect-money-success", name="office_perfect_money_success")
     */
    public function perfectMoneySuccessAction(Request $request)
    {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
//        $settings = $em->getRepository('BuxAdminSetupBundle:PaymentGateways\PerfectMoneySettings')->find(1);

        $paymentId          = $request->request->get('PAYMENT_ID');
        $payeeAccount       = $request->request->get('PAYEE_ACCOUNT');
        $paymentAmount      = $request->request->get('PAYMENT_AMOUNT');
        $paymentUnits       = $request->request->get('PAYMENT_UNITS');
        $paymentBatchNum    = $request->request->get('PAYMENT_BATCH_NUM');
        $phrase             = strtoupper(md5($this->get('service_container')->getParameter('pm_phrase')));
        $timeStampgmt       = $request->request->get('TIMESTAMPGMT');
        $v2Hash             = $request->request->get('V2_HASH');
        $payerAccount       = $request->request->get('PAYER_ACCOUNT');
        $batch              = $request->request->get('PAYMENT_BATCH_NUM');

        $string = $paymentId.':'.$payeeAccount.':'.$paymentAmount.':'.$paymentUnits.':'.$paymentBatchNum.':'.$payerAccount.':'.$phrase.':'.$timeStampgmt;
        $hash = strtoupper(md5($string));

        /* @var $user User */
        $user = $this->getUser();
        $userId = $user->getId();

//        $fp = fopen('perfect.txt', 'a');
//        fwrite($fp, "**************************************************************************\r\n");
//        fwrite($fp, "USER_ID:           $userId\r\n");
//        fwrite($fp, "PAYMENT_ID:        $paymentId\r\n");
//        fwrite($fp, "PAYEE_ACCOUNT:     $payeeAccount\r\n");
//        fwrite($fp, "PAYMENT_AMOUNT:    $paymentAmount\r\n");
//        fwrite($fp, "PAYMENT_UNITS:     $paymentUnits\r\n");
//        fwrite($fp, "PAYMENT_BATCH_NUM: $paymentBatchNum\r\n");
//        fwrite($fp, "TIMESTAMPGMT:      $timeStampgmt\r\n");
//        fwrite($fp, "V2_HASH:           $v2Hash\r\n");
//        fwrite($fp, "PAYER_ACCOUNT:     $payerAccount\r\n");
//        fwrite($fp, "PAYMENT_BATCH_NUM: $batch\r\n");

        if ($hash == $v2Hash) {
            if ($this->get('service_container')->getParameter('pm_account') == $payeeAccount && $this->get('service_container')->getParameter('pm_currency') == $paymentUnits) {
                $payment = $em->getRepository('StatisticBundle:WalletStatistic')->findOneBy(array(
                    'hash'  => $v2Hash,
                ));

                if (!$payment) {
                    $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array('name' => 'M'));
                    $wallet = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'type'  => $typeBalance,
                        'user'  => $user,
                    ));
                    $wallet->setSum($wallet->getSum() + $paymentAmount);

                    $em->flush();

                    $event = new WalletEvent($user, $paymentAmount, 'Perfect Money', $payerAccount, $v2Hash);
                    $dispatcher = $this->get('event_dispatcher');
                    $dispatcher->dispatch(WalletEvents::ADD_FUNDS_WALLET, $event);

                    // Save Transaction
                    $mainType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'M',
                    ));
                    $mainWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));
                    $mainAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));

                    $bonusType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'B',
                    ));
                    $bonusWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));
                    $bonusAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));

                    $event = new TransactionEvent($user, $paymentAmount, $mainWallet->getSum(), $bonusWallet->getSum(), $mainAccount->getSum(), $bonusAccount->getSum(), 1);
                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

//                    $event = new LogEvent($user, 1);
//                    $dispatcher->dispatch('save_log', $event);

                    $this->addFlash(
                        'success',
                        $this->get('translator')->trans('deposit.your_wallet_was_successfully_refilled')
                    );
//                    fwrite($fp, "**************************************************************************\r\n\r\n");
//                    fclose($fp);

                    $em->flush();

                    return $this->redirect($this->generateUrl('office_dashboard'));
                } else {
//                    fwrite($fp, "\r\nhash already exist\r\n");
                }
            } else {
//                fwrite($fp, "\r\nparameters does not match\r\n");
            }
        } else {
//            fwrite($fp, "\r\nhash does not match\r\n");
        }
//        fwrite($fp, "**************************************************************************\r\n\r\n");
//        fclose($fp);

        return $this->redirect($this->generateUrl('office_deposit'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/advcash-status", name="office_adv_cash_status")
     */
    public function advancedCashStatusAction(Request $request)
    {
        $walletClient           = $request->request->get('ac_src_wallet');
        $walletShop             = $request->request->get('ac_dest_wallet');
        $amount                 = $request->request->get('ac_amount');
        $price                  = $request->request->get('ac_merchant_amount');
        $currency               = $request->request->get('ac_merchant_currency');
        $commission             = $request->request->get('ac_fee');
        $payWithoutCommission   = $request->request->get('ac_buyer_amount_without_commission');
        $payWithCommission      = $request->request->get('ac_buyer_amount_with_commission');
        $clientCurrency         = $request->request->get('ac_buyer_currency');
        $advCash                = $request->request->get('ac_transfer');
        $shopName               = $request->request->get('ac_sci_name');
        $dateTransaction        = $request->request->get('ac_start_date');
        $orderId                = $request->request->get('ac_order_id');
        $paymentSystem          = $request->request->get('ac_ps');
        $statusTransaction      = $request->request->get('ac_transaction_status');
        $buyerEmail             = $request->request->get('ac_buyer_email');
        $buyerVerified          = $request->request->get('ac_buyer_verified');
        $comments               = $request->request->get('ac_comments');
        $operationId            = $request->request->get('operation_id');
        $login                  = $request->request->get('login');
        $acHash                 = $request->request->get('ac_hash');

        $name                   = 'EthereumPro';

//        $fp = fopen('advcashe.txt', 'a');
//        fwrite($fp, "**************************************************************************\r\n");
//        fwrite($fp, "walletClient:          $walletClient\r\n");
//        fwrite($fp, "walletShop:            $walletShop\r\n");
//        fwrite($fp, "amount:                $amount\r\n");
//        fwrite($fp, "price:                 $price\r\n");
//        fwrite($fp, "currency:              $currency\r\n");
//        fwrite($fp, "commission:            $commission\r\n");
//        fwrite($fp, "payWithoutCommission:  $payWithoutCommission\r\n");
//        fwrite($fp, "payWithCommission:     $payWithCommission\r\n");
//        fwrite($fp, "clientCurrency:        $clientCurrency\r\n");
//        fwrite($fp, "advCash:               $advCash\r\n");
//        fwrite($fp, "shopName:              $shopName\r\n");
//        fwrite($fp, "dateTransaction:       $dateTransaction\r\n");
//        fwrite($fp, "orderId:               $orderId\r\n");
//        fwrite($fp, "paymentSystem:         $paymentSystem\r\n");
//        fwrite($fp, "statusTransaction:     $statusTransaction\r\n");
//        fwrite($fp, "buyerEmail:            $buyerEmail\r\n");
//        fwrite($fp, "buyerVerified:         $buyerVerified\r\n");
//        fwrite($fp, "comments:              $comments\r\n");
//        fwrite($fp, "operationId:           $operationId\r\n");
//        fwrite($fp, "login:                 $login\r\n");
//        fwrite($fp, "acHash:                $acHash\r\n");
//        fwrite($fp, "**************************************************************************\r\n\r\n");
//        fclose($fp);

//        $hash = hash('sha256', '0a4a075c-5684-4733-a62d-30817e6474b1'.':'.'2016-02-12 06:04:37'.':'.'EthereumPro'.':'.'U10168601'.':'.'U839147555701'.':'.'1455257022'.':'.'0.01'.':'.'USD'.':'.$this->get('service_container')->getParameter('adv_password'));
        $hash = hash('sha256', $advCash.':'.$dateTransaction.':'.$name.':'.$walletClient.':'.$walletShop.':'.$orderId.':'.$amount.':'.$currency.':'.$this->get('service_container')->getParameter('adv_password'));

        if ($hash == $acHash) {
            if ($currency == $this->get('service_container')->getParameter('adv_currency')) {
                /* @var $em EntityManager */
                $em = $this->getDoctrine()->getManager();

                $payment = $em->getRepository('StatisticBundle:WalletStatistic')->findOneBy(array(
                    'hash'  => $hash,
                ));

                if (!$payment) {
                    $user = $em->getRepository('UserBundle:User')->findOneBy(array(
                        'email' => $login,
                    ));
                    $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array('name' => 'M'));
                    $wallet = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'type'  => $typeBalance,
                        'user'  => $user,
                    ));
                    $wallet->setSum($wallet->getSum() + $amount);

                    $em->flush();

                    $event = new WalletEvent($user, $amount, 'Advanced Cash', $walletClient, $hash);
                    $dispatcher = $this->get('event_dispatcher');
                    $dispatcher->dispatch(WalletEvents::ADD_FUNDS_WALLET, $event);

                    // Save Transaction
                    $mainType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'M',
                    ));
                    $mainWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));
                    $mainAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));

                    $bonusType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'B',
                    ));
                    $bonusWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));
                    $bonusAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));

                    $event = new TransactionEvent($user, $amount, $mainWallet->getSum(), $bonusWallet->getSum(), $mainAccount->getSum(), $bonusAccount->getSum(), 1);
                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                    $this->addFlash(
                        'success',
                        $this->get('translator')->trans('deposit.your_wallet_was_successfully_refilled')
                    );

                    $em->flush();
                }
            }
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/advcash-success", name="office_adv_cash_success")
     */
    public function advancedCashSuccess(Request $request)
    {
        return $this->redirectToRoute('office_dashboard');
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/payeer-callback", name="office_payeer_callback")
     */
    public function payeerCallbackAction(Request $request)
    {
        if ($request->get('m_operation_id') && $request->get('m_sign')) {
            /* @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            $secret = $this->get('service_container')->getParameter('payeer_secret');

            $arHash = array(
                $request->get('m_operation_id'),
                $request->get('m_operation_ps'),
                $request->get('m_operation_date'),
                $request->get('m_operation_pay_date'),
                $request->get('m_shop'),
                $request->get('m_orderid'),
                $request->get('m_amount'),
                $request->get('m_curr'),
                $request->get('m_desc'),
                $request->get('m_status'),
                $secret,
            );

//            dump($request->get('m_operation_id'));
//            dump($request->get('m_operation_ps'));
//            dump($request->get('m_operation_date'));
//            dump($request->get('m_operation_pay_date'));
//            dump($request->get('m_shop'));
//            dump($request->get('m_orderid'));
//            dump($request->get('m_amount'));
//            dump($request->get('m_curr'));
//            dump($request->get('m_desc'));
//            dump($request->get('m_status'));
//            dump($request->get('m_sign'));

            $signHash = strtoupper(hash('sha256', implode(':', $arHash)));
//            dump($signHash);
            if ($request->get('m_sign') == $signHash && $request->get('m_status') == 'success') {
                $payment = $em->getRepository('StatisticBundle:WalletStatistic')->findOneBy(array(
                    'hash'  => $request->get('m_sign'),
                ));

                if (!$payment) {
                    /* @var $user \UserBundle\Entity\User */
                    $user = $em->getRepository('UserBundle:User')->find($request->get('m_orderid'));
                    $typeBalance = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array('name' => 'M'));
                    $wallet = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'type'  => $typeBalance,
                        'user'  => $user,
                    ));

                    $wallet->setSum($wallet->getSum() + $request->get('m_amount'));

                    $em->flush();

                    $dispatcher = $this->get('event_dispatcher');

                    $event = new WalletEvent($user, $request->get('m_amount'), 'Payeer', null, $request->get('m_sign'));
                    $dispatcher->dispatch(WalletEvents::ADD_FUNDS_WALLET, $event);

                    // Save Transaction
                    $mainType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'M',
                    ));
                    $mainWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));
                    $mainAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $mainType,
                    ));

                    $bonusType = $em->getRepository('WalletBundle:TypeBalance')->findOneBy(array(
                        'name'  => 'B',
                    ));
                    $bonusWallet = $em->getRepository('WalletBundle:UserWallet')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));
                    $bonusAccount = $em->getRepository('WalletBundle:UserAccount')->findOneBy(array(
                        'user'  => $user,
                        'type'  => $bonusType,
                    ));

                    $event = new TransactionEvent($user, $request->get('m_amount'), $mainWallet->getSum(), $bonusWallet->getSum(), $mainAccount->getSum(), $bonusAccount->getSum(), 1);
                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

//                    $event = new LogEvent($user, 1);
//                    $dispatcher->dispatch('save_log', $event);

                    $this->get('session')->getFlashBag()->add(
                        'success',
                        $this->get('translator')->trans('office.add_funds.your_wallet_was_successfully_refilled')
                    );

                    $em->flush();

                    $session = $this->get('session');
                    $session->remove('payment_sum');

                    return $this->redirectToRoute('office_dashboard');

//                    echo $request->request->get('m_orderid').'|success';
//                    exit;
                }
            }

            return $this->redirectToRoute('office_dashboard');
        }

        return array();
    }
}
