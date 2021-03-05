<?php

namespace App\Form;

use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Nom'
                ]
            ])

            ->add('prenom',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Prenom'
                ]
            ])
            ->add('email',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Email'
                ]
            ])
            ->add('num',IntegerType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Numero de telephone'
                ]])
            ->add('specialite',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Specilité'
                ]
            ])
            ->add('pic',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Path of the picture'
                ]
            ])
            ->add('Envoyer', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-primary'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
