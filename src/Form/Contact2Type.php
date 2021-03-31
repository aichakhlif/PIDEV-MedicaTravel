<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Contact2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Objet'
                ]
            ])
            ->add('email', EmailType::class, [
                    'attr'=> ['class'=>'form-control']]

            )
            ->add('message', TextareaType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Votre message!'
                ]
            ])
            ->add('envoyer', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
