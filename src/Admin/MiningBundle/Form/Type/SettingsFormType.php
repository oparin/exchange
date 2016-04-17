<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 06.04.16
 * Time: 10:40
 */

namespace Admin\MiningBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SettingsFormType
 * @package Admin\MiningBundle\Form\Type
 */
class SettingsFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('progressBar', 'integer', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('multiplier', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('duration', 'integer', array(
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
            'data_class' => 'Admin\MiningBundle\Entity\Settings',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mining_settings_form';
    }
}
