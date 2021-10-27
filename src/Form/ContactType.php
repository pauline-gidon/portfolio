<?php

namespace App\Form;

use App\Form\ReCaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Votre nom *',
            'attr' => [
                'placeholder' => 'ex : Paul AUCHON',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'veuillez renseigner votre nom',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre email *',
            'attr' => [
                'placeholder' => 'paul.auchon@gmail.com',
            ],
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message *',
            'attr' => ['rows' => 5],
        ])
        
        ->add('captcha', ReCaptchaType::class, [
            'type' => 'invisible' // (invisible, checkbox)
         ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}