<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/15/16
 * Time: 4:44 PM
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ProfileFormType
 * @package UserBundle\Form\Type
 */
class ProfileFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->remove('username');
        $builder->remove('email');
        $builder->add('withdraw', 'collection', array(
            'type'      => new UserWithdrawType(),
            'required'  => false,
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_profile';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
