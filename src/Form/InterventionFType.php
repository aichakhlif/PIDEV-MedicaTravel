<?php

namespace App\Form;

use App\Entity\Intervention;
use DateTime;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('type',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Type'
                ]
            ])
            ->add('nom',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Nom'
                ]
            ])
            ->add('duree',TimeType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary dropdown-toggle','widget' => 'choice',
                    'input'  => 'datetime_immutable']
            ])

            ->add('tarif',IntegerType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'tarif'
                ]])
            ->add('medecin')


            ->add('Envoyer', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-primary'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
