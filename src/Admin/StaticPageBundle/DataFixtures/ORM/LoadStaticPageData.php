<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.02.2016
 * Time: 11:40
 */

namespace Admin\StaticPageBundle\DataFixtures\ORM;

use Admin\StaticPageBundle\Entity\StaticPage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadStaticPageData
 * @package Admin\StaticPageBundle\DataFixtures\ORM
 */
class LoadStaticPageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
//        $page = new StaticPage();
//        $page->setTitle('home');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);
//
//        $page = new StaticPage();
//        $page->setTitle('about');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);
//
//        $page = new StaticPage();
//        $page->setTitle('services');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);
//
//        $page = new StaticPage();
//        $page->setTitle('pages');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);
//
//        $page = new StaticPage();
//        $page->setTitle('blog');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);
//
//        $page = new StaticPage();
//        $page->setTitle('contact');
//        $page->setText('test');
//        $page->setLocale('en');
//        $manager->persist($page);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}