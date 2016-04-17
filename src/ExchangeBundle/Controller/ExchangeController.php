<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/15/15
 * Time: 11:38 AM
 */

namespace ExchangeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExchangeController
 * @package ExchangeBundle\Controller
 */
class ExchangeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/office-exchange", name="office_exchange")
     * @Template("ExchangeBundle:Exchange:exchange.html.twig")
     */
    public function buyAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $orderSell  = $em->getRepository('ExchangeBundle:Bid')->findBy(array(
            'type'      => true,
            'status'    => false,
        ), array('price' => 'ASC'));

        $orderBuy  = $em->getRepository('ExchangeBundle:Bid')->findBy(array(
            'type'      => false,
            'status'    => false,
        ), array('price' => 'DESC'));

        $qb = $em->getRepository('ExchangeBundle:Trade')->createQueryBuilder('tr');
        $qb
            ->orderBy('tr.id', 'DESC')
            ->setMaxResults(100);
        $trades = $qb->getQuery()->getResult();

        $data = array(
            array(
                "date"  => "2011-08-02",
                "open"  => "135.26",
                "high"  => "135.95",
                "low"   => "131.50",
                "close" => "131.85",
            ),
        );

        $qb = $em->getRepository('ExchangeBundle:Statistic')->createQueryBuilder('st');
        $qb
            ->select('st.date', 'st.open', 'st.high', 'st.low', 'st.close')
            ->orderBy('st.id', 'DESC')
            ->setMaxResults(100);
        $data   = $qb->getQuery()->getArrayResult();
        $data   = array_reverse($data);
        foreach ($data as &$day) {
            $day['date'] = $day['date']->format('h:i');
        }

        return array(
            'orders_sell'   => $orderSell,
            'orders_buy'    => $orderBuy,
            'trades'        => $trades,
            'data'          => $data,
        );
    }
}
