<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Snowboards;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom')
            // ->add('prix')
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom'
            ])

            ->add('Rechercher', SubmitType::class)
            // ->add('cambre')
            // ->add('marque')
            // ->add('niveau')
            // ->add('programme')
            // ->add('shape')
            // ->add('snowinsert')
        ;
    }
}