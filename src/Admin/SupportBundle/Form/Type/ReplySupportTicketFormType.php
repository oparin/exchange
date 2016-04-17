<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/18/15
 * Time: 3:53 PM
 */

namespace Admin\SupportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ReplySupportTicketFormType
 * @package Admin\SupportBundle\Form\Type
 */
class ReplySupportTicketFormType extends AbstractType
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
            ))
            ->add('closed', 'checkbox', array(
                'required'  => false,
                'mapped'    => false,
                'label'     => 'Закрыть тикет',
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setOptions(OptionsResolver $resolver)
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
        return 'new_support_reply_form_type';
    }
}
