<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 10:27 AM
 */

namespace Admin\MarketingBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class BinaryProfitFormType
 * @package Admin\MarketingBundle\Form\Type
 */
class BinaryProfitFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statusFrom', 'entity', array(
                'class'         => 'Admin\SettingsBundle\Entity\MemberStatus',
                'property'      => 'name',
                'empty_value'   => ' ',
                'constraints'   => new NotBlank(),
            ))
            ->add('statusTo', 'entity', array(
                'class'         => 'Admin\SettingsBundle\Entity\MemberStatus',
                'property'      => 'name',
                'empty_value'   => ' ',
                'constraints'   => new NotBlank(),
            ))
            ->add('points', 'number', array(
                'constraints'   => new NotBlank(),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MarketingBundle\Entity\BinaryProfit',
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
