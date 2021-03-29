<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Intervention;
use App\Entity\Medecin;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('Specialite',EntityType::class,[
                'class' => Specialite::class,
                'label'=> false,
                'required'=> false,
                'expanded'=> true,
                'multiple'=> true

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}