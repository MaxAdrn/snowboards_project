<?php

namespace App\Form;

use App\Entity\Cambre;
use App\Entity\Genre;
use App\Entity\Marque;
use App\Entity\Niveau;
use App\Entity\Programme;
use App\Entity\Shape;
use App\Entity\Snowboards;
use App\Entity\Snowinsert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom'
            ])
            ->add('cambre', EntityType::class, [
                'class' => Cambre::class,
                'choice_label' => 'nom'
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'nom'
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom'
            ])
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => 'nom'
            ])
            ->add('shape', EntityType::class, [
                'class' => Shape::class,
                'choice_label' => 'nom'
            ])
            ->add('snowinsert', EntityType::class, [
                'class' => Snowinsert::class,
                'choice_label' => 'nom'
            ])
            ->add('Rechercher', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Snowboards::class,
        ]);
    }
}
