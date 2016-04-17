<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/17/15
 * Time: 3:21 PM
 */

namespace Admin\MemberBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MemberFormType
 * @package Admin\MemberBundle
 */
class MemberFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('email', 'email', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('wallets', 'collection', array(
                'type' => new UserWalletFormType(),
            ))
            ->add('accounts', 'collection', array(
                'type' => new UserAccountFormType(),
            ))
            ->add('currency', 'collection', array(
                'type' => new UserCurrencyFormType(),
            ))
            ->add('rating', 'integer', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('locked', 'checkbox', array(
                'required'  => false,
            ))
            ->add('registrationBonus', 'money', array(
                'required'  => false,
                'currency'  => 'USD',
            ))
            ->add('rating', 'integer', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('miningRights', 'number', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('poolWallet', 'number', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
        ))
            ->setRequired(array(
                'em',
            ))
            ->setAllowedTypes(array(
                'em' => 'Doctrine\Common\Persistence\ObjectManager',
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'member_form_type';
    }
}
