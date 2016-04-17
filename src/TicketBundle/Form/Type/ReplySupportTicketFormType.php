<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/18/15
 * Time: 10:58 AM
 */

namespace TicketBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ReplySupportTicketFormType
 * @package TicketBundle\Form\Type
 */
class ReplySupportTicketFormType extends \Symfony\Component\Form\AbstractType
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TicketBundle\Entity\ReplySupportTicket',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'reply_support_ticket_form_type';
    }
}
