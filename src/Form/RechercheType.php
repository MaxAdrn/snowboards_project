<?php

namespace App\Form;

use App\Entity\Snowboards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('genre')
            ->add('cambre')
            ->add('marque')
            ->add('niveau')
            ->add('programme')
            ->add('shape')
            ->add('snowinsert')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Snowboards::class,
        ]);
    }
}
