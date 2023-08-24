<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre: ",
                'label_attr' => ['class' => '...'],
                'attr' => ['placeholder' => "Choisissez le titre du livre", 'class' => '...']
            ])
            ->add('summary', options: [
                'label' => "Résumé: ",
                'help' => "Le résumé peut être écrit avec des balises HTML"
            ])
            ->add('publication_date', options: [
                'label' => "Date de publication: ",
                'widget' => "single_text"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'required' => false
        ]);
    }
}
