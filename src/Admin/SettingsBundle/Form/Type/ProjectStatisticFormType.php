<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/2/15
 * Time: 11:24 AM
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ProjectStatisticFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class ProjectStatisticFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'widget'    => 'single_text'
            ))
            ->add('averageTime', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('averageAmount', 'money', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'currency'  => 'USD',
            ))
            ->add('averageRate', 'number', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('numberMembers', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('newMembers', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('amountTransactions', 'money', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'currency'  => 'USD',
            ))
            ->add('transactionsOnExchange', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('numberTransactions', 'integer', array(
                'constraints' => array(
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
            'data_class' => 'Admin\SettingsBundle\Entity\ProjectStatistic',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'project_statistic_form';
    }
}
