<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/20/16
 * Time: 9:58 AM
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\MemberStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMemberStatusData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadMemberStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = new \DateTime();

        $status = new MemberStatus();
        $status->setName('Silver');
        $status->setPrice(50);
        //$status->setSponsorBonus(8);
        $status->setPercent(8);
        $status->setImage('2uop4lh.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription('<h5>Product Description</h5><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula.</p><p>Dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus. Pellentesque sed felis ipsum. Quisque in lacus sed ante malesuada condimentum et a risus.</p>');
        $manager->persist($status);
        $this->addReference('silver', $status);

        $status = new MemberStatus();
        $status->setName('Gold');
        $status->setPrice(199);
        //$status->setSponsorBonus(10);
        $status->setPercent(10);
        $status->setImage('2uop4lh.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription('<h5>Product Description</h5><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula.</p><p>Dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus. Pellentesque sed felis ipsum. Quisque in lacus sed ante malesuada condimentum et a risus.</p>');
        $manager->persist($status);
        $this->addReference('gold', $status);

        $status = new MemberStatus();
        $status->setName('Diamond');
        $status->setPrice(499);
        //$status->setSponsorBonus(12);
        $status->setPercent(12);
        $status->setImage('2uop4lh.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription('<h5>Product Description</h5><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula.</p><p>Dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus. Pellentesque sed felis ipsum. Quisque in lacus sed ante malesuada condimentum et a risus.</p>');
        $manager->persist($status);
        $this->addReference('diamond', $status);

        $status = new MemberStatus();
        $status->setName('Ethereum');
        $status->setPrice(999);
        //$status->setSponsorBonus(15);
        $status->setPercent(15);
        $status->setImage('2uop4lh.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription('<h5>Product Description</h5><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula.</p><p>Dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus. Pellentesque sed felis ipsum. Quisque in lacus sed ante malesuada condimentum et a risus.</p>');
        $manager->persist($status);
        $this->addReference('ethereum', $status);

        $status = new MemberStatus();
        $status->setName('Ethereum PRO');
        $status->setPrice(1999);
        //$status->setSponsorBonus(20);
        $status->setPercent(20);
        $status->setImage('2uop4lh.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription('<h5>Product Description</h5><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula.</p><p>Dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus. Pellentesque sed felis ipsum. Quisque in lacus sed ante malesuada condimentum et a risus.</p>');
        $manager->persist($status);
        $this->addReference('ethereum_pro', $status);

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
