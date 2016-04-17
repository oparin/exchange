<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 06.04.16
 * Time: 12:33
 */

namespace OfficeBundle\Command;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\MiningStatistic;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MiningCommand
 * @package OfficeBundle\Command
 */
class MiningCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('start:mining')
            ->setDescription('Start Mining');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new \DateTime();

        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $qb = $em->getRepository('StatisticBundle:MiningStatistic')->createQueryBuilder('ms');
        $qb
            ->where('ms.status = false')
            ->andWhere('ms.endDate < :date')
            ->setParameter('date', $date);
        $records = $qb->getQuery()->getResult();

        if ($records) {
            $settings = $em->getRepository('AdminMiningBundle:Settings')->findOneBy(array());

            /** @var $record MiningStatistic */
            foreach ($records as $record) {
                $user = $record->getUser();
                $user->setMiningRightsInWork($user->getMiningRightsInWork() - $record->getMiningRights());
                $user->setPoolWallet($user->getPoolWallet() + $record->getMiningRights() * $settings->getMultiplier());
                $record->setStatus(true);
            }

            $em->flush();
        }

        $output->writeln(count($records));
    }
}
