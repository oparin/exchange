<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 2:30 PM
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ArbitrageSettingsFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class ArbitrageSettingsFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('multiplier', 'integer', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('arbitrageMaxSum', 'money', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
                'currency'  => 'USD',
            ))
            ->add('commission', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('arbitrageFinePercent', 'number', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('arbitrageProlongation', 'number', array(
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
            'data_class' => 'Admin\SettingsBundle\Entity\ArbitrageSettings',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arbitrage_settings_form';
    }
}
