<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.02.16
 * Time: 9:57
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ReferralBonusFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class ReferralBonusFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statusFrom', 'entity', array(
                'class'         => 'Admin\SettingsBundle\Entity\MemberStatus',
                'property'      => 'name',
                'empty_value'   => ' ',
                'constraints'   => new NotBlank(),
            ))
            ->add('statusTo', 'entity', array(
                'class'         => 'Admin\SettingsBundle\Entity\MemberStatus',
                'property'      => 'name',
                'empty_value'   => ' ',
                'constraints'   => new NotBlank(),
            ))
            ->add('bonus', 'number', array(
                'constraints'   => new NotBlank(),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\SettingsBundle\Entity\ReferralBonus',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'referral_bonus_form';
    }
}
