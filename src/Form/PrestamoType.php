<?php

namespace App\Form;

use App\Entity\Libro;
use App\Entity\Prestamo;
use App\Entity\libro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaPrestamo')
            ->add('fechaDevolucion')
            ->add('estado')
            ->add('observaciones')
            ->add('relation')
            ->add('libro', EntityType::class, [
                'class' => Libro::class,
                'choice_label' => 'id',
            ])
            ->add('usuario', EntityType::class, [
                'class' => libro::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestamo::class,
        ]);
    }
}
