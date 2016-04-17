<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 3:21 PM
 */

namespace OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ArbitrageFormType
 * @package OfficeBundle\Form\Type
 */
class ArbitrageFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', 'choice', array(
                'choices'   => array(
                    '5'     => 5,
                    '6'     => 6,
                    '7'     => 7,
                    '8'     => 8,
                    '9'     => 9,
                    '10'    => 10,
                ),
                'constraints'   => array(
                    new NotBlank(),
                ),
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arbitrage_form_type';
    }
}
