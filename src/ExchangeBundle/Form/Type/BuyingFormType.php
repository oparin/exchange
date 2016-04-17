<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/14/15
 * Time: 12:04 PM
 */

namespace ExchangeBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Translation\DataCollectorTranslator;

/**
 * Class BuyingFormType
 * @package ExchangeBundle
 */
class BuyingFormType extends AbstractType
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
            ->add('typeBalance', 'entity', array(
                'class' => 'WalletBundle:TypeBalance',
                'choices' => $choices,
                'property'  => 'name',
                'choice_translation_domain' => true,
            ));
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
        return 'buying_form_type';
    }
}
