<?php

namespace App\Form;

use App\Entity\Intervention;
use App\Entity\Specialite;
use DateTime;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('description',TextareaType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'description'
                ]
            ])


            ->add('Specialite',EntityType::class,[
                'class' => Specialite::class,
                'multiple'=>false,
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Specilité'
                ]
            ])


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
            'data_class' => Intervention::class,
        ]);
    }
}
