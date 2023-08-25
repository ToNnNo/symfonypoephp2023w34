<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', SearchType::class, [
                'attr' => [
                    'placeholder' => "Rechercher un livre",
                    'class' => "form-control-sm"
                ],
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
