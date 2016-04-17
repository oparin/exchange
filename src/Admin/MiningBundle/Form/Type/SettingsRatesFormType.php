<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 05.04.16
 * Time: 15:37
 */

namespace Admin\MiningBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class SettingsRatesFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('buy', 'number', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('sell', 'number', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('convertat', 'number', array(
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
            'data_class' => 'Admin\MiningBundle\Entity\Rate',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mining_settings_rates_form';
    }
}