<?php
/**
 * Created by PhpStorm.
 * User: oparin
 * Date: 7/25/15
 * Time: 12:19 PM
 */

namespace TicketBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class NewSupportTicketFormType
 * @package Matrix\OfficeBundle\Form\Support\Type
 */
class NewSupportTicketFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('text', 'textarea', array(
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
            'data_class' => 'TicketBundle\Entity\SupportTicket',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'new_support_ticket_form_type';
    }
}
