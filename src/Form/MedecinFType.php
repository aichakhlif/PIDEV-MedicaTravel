<?php

namespace App\Form;

use App\Entity\Clinique;
use App\Entity\Medecin;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
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
            ->add('clinique',EntityType::class,[
                'class' => Clinique::class,
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'clinique'
                ]
            ])
            ->add('email',EmailType::class,[
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
            ->add('Specialite',EntityType::class,[
                'class' => Specialite::class,
                'multiple'=>true,
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Specilité'
                ]
            ])

            ->add('pic',FileType::class,
                array('data_class'=>null,'required' => false,'mapped'=>false))


            ->add('Envoyer', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-primary'
                ]])
            ->add('Annuler', ResetType::class,[
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