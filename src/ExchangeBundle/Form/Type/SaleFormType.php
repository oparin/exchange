<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/15/15
 * Time: 10:34 AM
 */

namespace ExchangeBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SaleFormType
 * @package ExchangeBundle\Form\Type
 */
class SaleFormType extends AbstractType
{
    protected $em;
    protected $translator;

    /**
     * BuyingFormType constructor.
     * @param EntityManager           $em
     * @param DataCollectorTranslator $translator
     */
    public function __construct(EntityManager $em, $translator)
    {
        $this->em           = $em;
        $this->translator   = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $qb = $this->em->getRepository('WalletBundle:TypeBalance')->createQueryBuilder('tb');
        $qb
            ->where("tb.name = 'M'");
        $choices = $qb->getQuery()->getResult();

        $builder
            ->add('quantity', 'number', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('price', 'money', array(
                'currency'      => 'USD',
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('typeB', 'choice', array(
                'choices'   => array('M' => $this->translator->trans('sale.main_eth_account')),
                'mapped'    => false,
            ));
//            ->add('typeBalance', 'entity', array(
//                'class' => 'WalletBundle:TypeBalance',
//                'choices' => $choices,
//                'property'  => 'name',
//                'choice_translation_domain' => true,
//            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ExchangeBundle\Entity\Bid',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sale_form_type';
    }
}
