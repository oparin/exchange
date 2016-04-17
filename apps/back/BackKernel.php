<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class BackKernel
 */
class BackKernel extends Kernel
{
	/**
     * FrontKernel constructor.
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($environment, $debug)
    {
//        date_default_timezone_set('America/Detroit');
        date_default_timezone_set('Europe/Paris');
        parent::__construct($environment, $debug);
    }
	
    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new APY\DataGridBundle\APYDataGridBundle(),
            new Admin\UserBundle\AdminUserBundle(),
            new Admin\MemberBundle\AdminMemberBundle(),
            new Admin\SettingsBundle\AdminSettingsBundle(),
            new UserBundle\UserBundle(),
            new WalletBundle\WalletBundle(),
            new TicketBundle\TicketBundle(),
            new ExchangeBundle\ExchangeBundle(),
            new Admin\SupportBundle\AdminSupportBundle(),
            new Admin\NewsBundle\AdminNewsBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new MarketingBundle\MarketingBundle(),
            new Admin\MarketingBundle\AdminMarketingBundle(),
            new StatisticBundle\StatisticBundle(),
            new Admin\ArbitrageBundle\AdminArbitrageBundle(),
            new OfficeBundle\OfficeBundle(),
            new Admin\WalletBundle\AdminWalletBundle(),
            new Admin\StaticPageBundle\AdminStaticPageBundle(),
            new Admin\MiningBundle\AdminMiningBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
