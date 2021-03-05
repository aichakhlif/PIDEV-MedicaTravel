<?php

namespace App\Form;
use App\Entity\Reservation;
use App\Entity\Medecin;
use App\Entity\Intervention;
use App\Entity\Offre;




use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservationformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      //  $offre = $options['offre'];

        $builder

           ->add('nom',TextType::class)
           ->add('prenom',TextType::class)
           ->add('email',TextType::class)
           ->add('date_n',TextType::class)
            ->add('tel',TextType::class)
           ->add('pays',TextType::class)
           ->add('offre')

      //  ->add('offre', HiddenType::class, [
       // 'data' => $offre,
       // 'data_class' => null,])




        ;}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
