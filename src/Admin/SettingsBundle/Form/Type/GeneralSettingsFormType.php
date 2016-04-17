<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 4:42 PM
 */
namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class GeneralSettingsFormType
 * @package Admin\SettingsBundle
 */
class GeneralSettingsFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siteName', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('registrationBonus', 'money', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
                'currency'  => 'USD',
            ))
            ->add('tickerOne', 'textarea', array(
                'required'  => false,
            ))
            ->add('tickerTwo', 'textarea', array(
                'required'  => false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\SettingsBundle\Entity\Settings',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'general_settings_form';
    }
}
