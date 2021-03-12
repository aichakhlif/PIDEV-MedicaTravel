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




class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',TextType::class)
            ->add('date_n',DateType::class)
            ->add('tel',TextType::class)
            ->add('pays',TextType::class)
            ->add('medecin')
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
