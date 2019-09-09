<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (in_array('registration', $options['validation_groups'])) {
            $builder
                ->add('username')
                ->add('email', EmailType::class)
                ->add('password', PasswordType::class)
                ->add('confirm_password', PasswordType::class);
        }
        if (in_array('profil', $options['validation_groups'])){
            $builder
                ->add('username')
                ->add('email', EmailType::class);
        }
        if (in_array('password', $options['validation_groups'])){
            $builder
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
