<?php

namespace App\Form;

use App\Entity\Offre;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clinique', EntityType::class,[
                'class'=>'App\Entity\Clinique',
                'placeholder'=>'Sélectionnez Une Clinique',
                'required'=>false,
            ])


            ->add('intervention', EntityType::class,[
                'class'=>'App\Entity\Intervention',
                'placeholder'=>'Sélectionnez Une Intervention',
                'required'=>false,
            ])
            ->add('date')
            ->add('prix',IntegerType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'placeholder'=>'Prix'
                ]])

            ->add('Envoyer', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn btn-primary',

                ]])
        ;
        $builder->get('clinique')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form=$event->getForm();
                $form->getParent()->add('medecin',EntityType::class,[
                    'class'=>'App\Entity\Medecin',
                    'placeholder'=>'Liste Médecins',
                    'mapped'=>true,
                    'required'=>false,
                    'choices'=>$form->getData()->getMedecin(),
                ]);

            }
        );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}