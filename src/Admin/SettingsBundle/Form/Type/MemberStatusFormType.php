<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/1/15
 * Time: 9:25 AM
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MemberStatusFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class MemberStatusFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('price', 'money', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
                'currency'  => 'USD',
            ))
//            ->add('sponsorBonus', 'text', array(
//                'constraints'   => array(
//                    new NotBlank(),
//                ),
//            ))
            ->add('percent', 'text', array(
                'constraints'   => array(
                    new NotBlank(),
                ),
            ))
            ->add('imageFile', 'file', array(
                'required'  => false,
            ))
            ->add('description', 'textarea', array(
                'attr'  => array(
                    'class' => "tinymce",
                    'rows'  => 20,
                ),
                'label_attr' => array(
                    'display'   => 'none',
                ),
            ))
            ->add('miningRights', 'number', array(
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
            'data_class' => 'Admin\SettingsBundle\Entity\MemberStatus',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'member_status_form';
    }
}
