<?php

namespace App\Form;
use App\Entity\Reservation;
use App\Entity\Medecin;
use App\Entity\Intervention;
use App\Entity\Offre;






use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      //  $offre = $options['offre'];

        $builder

           ->add('nom',TextType::class)
           ->add('email',TextType::class)
           ->add('pays',TextType::class)


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
