<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/17/15
 * Time: 3:39 PM
 */

namespace Admin\MemberBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserWalletFormType
 * @package Admin\MemberBundle\Form\Type
 */
class UserWalletFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sum', 'money', array(
            'constraints'   => array(
                new NotBlank(),
            ),
            'currency'  => 'USD',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WalletBundle\Entity\UserWallet',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_wallet';
    }
}
