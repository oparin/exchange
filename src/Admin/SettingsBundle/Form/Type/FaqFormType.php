<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/13/16
 * Time: 2:31 PM
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class FaqFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class FaqFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('text', 'textarea', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('locale', 'text', array(
                'constraints' => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\SettingsBundle\Entity\Faq',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'faq_form';
    }
}
