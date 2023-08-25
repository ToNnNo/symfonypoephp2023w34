<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => "Auteur: ",
                'placeholder' => "-- Liste des auteurs --"
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
