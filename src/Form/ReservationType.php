<?php

namespace App\Form;
use App\Entity\Reservation;
use App\Entity\Medecin;
use App\Entity\Intervention;
use App\Entity\Clinique;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          //->add('nom',TextType::class)
            ->add('nom', TextType::class, array('attr' =>array(
                'class' => 'form-control',
                'autofocus' => true,
                'placeholder' => 'nom',

            )))

            ->add('email',TextType::class)
            ->add('pays',TextType::class)
         //   ->add('medecin')

            ->add('medecin',EntityType::class,
                array(
                    'class'=> 'App\Entity\Medecin',
                    'choice_label'=>'nom',
                    'multiple'=>false))

        ->add('intervention')
            ->add('clinique')



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
