<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/17/16
 * Time: 10:03 AM
 */

namespace UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserWithdrawType
 * @package UserBundle\Form\Type
 */
class UserWithdrawType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account', 'text', array(
                'label' => ' ',
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WalletBundle\Entity\UserWithdraw',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_withdraw_form_type';
    }
}
