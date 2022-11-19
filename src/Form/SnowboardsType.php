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
use App\Repository\MarqueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SnowboardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter le nom'
                    ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter la description'
                    ]
            ])
            ->add('prix', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter le prix'
                    ]
            ])
            ->add('genre', EntityType::class, [
                'placeholder' => 'Choisir un genre',
                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'nom'
            ])
            ->add('cambre', EntityType::class, [
                'placeholder' => 'Choisir le type de cambre',
                'required' => false,
                'class' => Cambre::class,
                'choice_label' => 'nom'
            ])
            ->add('marque', EntityType::class, [
                'placeholder' => 'Choisir une marque',
                'required' => false,
                'class' => Marque::class,
                'choice_label' => 'nom',
                'query_builder' => function (MarqueRepository $marque) {
                    return $marque->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC');
                }
            ])
            ->add('niveau', EntityType::class, [
                'placeholder' => 'Choisir un niveau',
                'required' => false,
                'class' => Niveau::class,
                'choice_label' => 'nom'
            ])
            ->add('programme', EntityType::class, [
                'placeholder' => 'Choisir le type de programme',
                'required' => false,
                'class' => Programme::class,
                'choice_label' => 'nom'
            ])
            ->add('shape', EntityType::class, [
                'placeholder' => 'Choisir le type de shape',
                'required' => false,
                'class' => Shape::class,
                'choice_label' => 'nom'
            ])
            ->add('snowinsert', EntityType::class, [
                'placeholder' => 'Choisir le type d\'insert',
                'required' => false,
                'label' => 'Insert',
                'class' => Snowinsert::class,
                'choice_label' => 'nom'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif'
                        ],
                        'maxSizeMessage' => 'Max 1Mo',
                        'mimeTypesMessage' => 'Format jpeg, png, gif ou webp requis'
                    ])
                ]
            ])
            ->add('taille', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter la taille'
                    ]
            ])
            ->add('stock', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter le stock'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Snowboards::class,
        ]);
    }
}
