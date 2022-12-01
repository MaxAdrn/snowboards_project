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
                    'placeholder' => 'Ajouter le nom',
                    'required' => true
                    ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter la description',
                    'required' => true
                    ]
            ])
            ->add('prix', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter le prix',
                    'required' => true
                    ]
            ])
            ->add('stock', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Ajouter le stock',
                    'required' => true
                    ]
            ])
            ->add('genre', EntityType::class, [
                'placeholder' => 'Choisir un genre',
                'required' => true,
                'class' => Genre::class,
                'choice_label' => 'nom'
            ])
            ->add('cambre', EntityType::class, [
                'placeholder' => 'Choisir le type de cambre',
                'required' => true,
                'class' => Cambre::class,
                'choice_label' => 'nom'
            ])
            ->add('niveau', EntityType::class, [
                'placeholder' => 'Choisir un niveau',
                'required' => true,
                'class' => Niveau::class,
                'choice_label' => 'nom'
                ])
            ->add('marque', EntityType::class, [
                'placeholder' => 'Choisir une marque',
                'required' => true,
                'class' => Marque::class,
                'choice_label' => 'nom',
                'query_builder' => function (MarqueRepository $marque) {
                    return $marque->createQueryBuilder('m')
                        ->orderBy('m.nom', 'ASC');
                }
            ])
            ->add('programme', EntityType::class, [
                'placeholder' => 'Choisir le type de programme',
                'required' => true,
                'class' => Programme::class,
                'choice_label' => 'nom'
            ])
            ->add('shape', EntityType::class, [
                'placeholder' => 'Choisir le type de shape',
                'required' => true,
                'class' => Shape::class,
                'choice_label' => 'nom'
            ])
            ->add('snowinsert', EntityType::class, [
                'placeholder' => 'Choisir le type d\'insert',
                'required' => true,
                'label' => 'Insert',
                'class' => Snowinsert::class,
                'choice_label' => 'nom'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Maximum 1Mo',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Format .jpeg, .jpg, .png ou .webp requis'
                    ])
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
