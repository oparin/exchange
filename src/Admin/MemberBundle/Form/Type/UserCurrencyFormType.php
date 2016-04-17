<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/29/16
 * Time: 4:55 PM
 */

namespace Admin\MemberBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserCurrencyFormType
 * @package Admin\MemberBundle\Form\Type
 */
class UserCurrencyFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sum', 'money', array(
            'constraints'   => array(new NotBlank()),
            'currency'  => 'USD',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WalletBundle\Entity\UserCurrency',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_currency';
    }
}