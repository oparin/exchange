<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.02.2016
 * Time: 12:49
 */

namespace Admin\StaticPageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class StaticPageFormType
 * @package Admin\StaticPageBundle
 */
class StaticPageFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'textarea', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\StaticPageBundle\Entity\StaticPage',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'static_page_form_type';
    }
}