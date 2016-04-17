<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/13/16
 * Time: 4:18 PM
 */

namespace OfficeBundle\Command;

use Admin\SettingsBundle\Entity\ProjectStatistic;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MaxCourseCommand
 * @package OfficeBundle\Command
 */
class MaxCourseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('save:maxcourse')
            ->setDescription('Save Max Course');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new \DateTime();

        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $qb = $em->getRepository('ExchangeBundle:Statistic')->createQueryBuilder('s');
        $qb
            ->select('MAX(s.high)')
            ->where('s.date > :date')
            ->setParameter('date', $date->modify('-1 day'));
        $result = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $maxResult = new ProjectStatistic();
        $maxResult->setMaxCourse($result);
        $maxResult->setDate($date);
        $em->persist($maxResult);
        $em->flush($maxResult);

        $output->writeln($result);
    }
}
