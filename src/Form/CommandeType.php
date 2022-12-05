<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseLiv', TextType::class, [
                'label' => 'Adresse de livraison',
                'attr' => [
                    'placeholder' => 'Adresse de livraison',
                    ]
            ])
            ->add('adresseFacturation', TextType::class, [
                'label' => 'Adresse de facturation',
                'attr' => [
                    'placeholder' => 'Adresse de facturation',
                    ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                    ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom',
                    ]
            ])
            ->add('societe', TextType::class, [
                'label' => 'Société (facultatif)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Société (facultatif)',
                    ]
            ])
            ->add('cgv', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les CGV',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGV.',
                    ]),
                ],
            ])
            // ->add('montant')
            // ->add('detailCommande')
            // ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
