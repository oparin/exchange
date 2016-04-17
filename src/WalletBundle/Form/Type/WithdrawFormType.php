<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/25/16
 * Time: 12:39 PM
 */

namespace WalletBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;

/**
 * Class WithdrawFormType
 * @package WalletBundle\Form\Type
 */
class WithdrawFormType extends AbstractType
{
    protected $user;

    /**
     * WithdrawFormType constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sum', 'number', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('type', 'entity', array(
                'class' => 'WalletBundle\Entity\UserWithdraw',
                'property'  => 'type',
                'query_builder' => function (EntityRepository $er) {
                    return  $er->createQueryBuilder('wf')
                        ->where('wf.user = :user' )
                        ->andWhere('wf.account IS NOT NULL')
                        ->setParameter('user', $this->user);
                },
            ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'withdraw_form_type';
    }
}
