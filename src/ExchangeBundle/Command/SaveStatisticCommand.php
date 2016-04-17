<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/17/15
 * Time: 2:53 PM
 */

namespace ExchangeBundle\Command;

use Doctrine\ORM\EntityManager;
use ExchangeBundle\Entity\Statistic;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SaveStatisticCommand
 * @package ExchangeBundle\Command
 */
class SaveStatisticCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('exchange:save:trades')
            ->setDescription('Save trades');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dateOld = new \DateTime();
        $dateNew = new \DateTime();

        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $lastStat   = $em->getRepository('ExchangeBundle:Statistic')->findOneBy(array(), array('id' => 'DESC'));

        $qb = $em->getRepository('ExchangeBundle:Trade')->createQueryBuilder('tr');
        $qb
            ->select('MAX(bb.price) as max_price, MIN(bb.price) as min_price')
            ->leftJoin('tr.buyBid', 'bb')
            ->where('tr.date > :date')
            ->setParameter('date', $dateOld->modify('-4 hour'));
        $result = $qb->getQuery()->getOneOrNullResult();
        if ($result['max_price']) {
            $lastTrade = $em->getRepository('ExchangeBundle:Trade')->findOneBy(array(), array('id' => 'DESC'));
            $newStat    = new Statistic();
            $newStat->setDate($dateNew);
            $newStat->setOpen($lastStat->getClose());
            $newStat->setHigh($result['max_price']);
            $newStat->setLow($result['min_price']);
            $newStat->setClose($lastTrade->getBuyBid()->getPrice());
            $em->persist($newStat);
            $em->flush($newStat);
        } else {
            $newStat    = new Statistic();
            $newStat->setDate($dateNew);
            $newStat->setOpen($lastStat->getClose());
            $newStat->setHigh($lastStat->getClose());
            $newStat->setLow($lastStat->getClose());
            $newStat->setClose($lastStat->getClose());
            $em->persist($newStat);
            $em->flush($newStat);
        }

        $output->writeln('ok!');
    }
}
