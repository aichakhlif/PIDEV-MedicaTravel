<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TextType;use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Flex\Options;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre', TextType::class ,['attr'=>['class'=>'form-control','novalidate' => 'novalidate']] )
            ->add('Image',FileType::class,array('data_class'=>null,'required' => false,'mapped'=>false))
            ->add('Contenu' ,TextareaType::class, ['attr'=>['class'=>'form-control','novalidate' => 'novalidate']])
            ->add('Cat', EntityType::class,[ 'label' =>'Catégorie',
                'class' => Categorie::class,
                'mapped'=>'false',
                'attr'=>['class'=>'form-control','novalidate' => 'novalidate']])
            ->add('Auteur',TextType::class,['attr'=>['class'=>'form-control','novalidate' => 'novalidate']])



        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
