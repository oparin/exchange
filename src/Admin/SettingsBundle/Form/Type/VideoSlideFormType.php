<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/13/16
 * Time: 10:29 AM
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VideoSlideFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class VideoSlideFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('videoFile', 'file', array(
                'required'  => false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\SettingsBundle\Entity\VideoSlide',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'video_slide_form';
    }
}
