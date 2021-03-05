<?php

namespace App\Form;

use App\Entity\Clinique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CliniqueFormType extends AbstractType
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
            ->add('adresse',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Adresse'
                ]])
            ->add('tel',IntegerType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Numéro téléphone'
                ]])
            ->add('image',TextType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Url image'
                ]])
            ->add('Envoyer', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-primary',
                    'placeholder'=>'Nom'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clinique::class,
        ]);
    }
}
