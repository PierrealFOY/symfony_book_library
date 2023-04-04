<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'attr'  => [
                    "placeholder" => "Titre du livre"
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur du livre',
                'attr'  => [
                    "placeholder" => "Auteur du livre"
                ]
            ])
            ->add('genre', ChoiceType::class, [
                "placeholder" => "Choisissez un genre",
                "choices" => [
                    "genre" => [
                        'Roman' => 'Roman',
                        'Policier' => 'Policier', 
                        'Science-fiction' => 'Science-fiction', 
                        'Fantastique' => 'Fantastique', 
                        'Biographie' => 'Biographie', 
                        'Histoire' => 'Histoire', 
                        'Théâtre' => 'Théâtre', 
                        'Poésie' => 'Poésie', 
                        'Essai' => 'Essai', 
                        'Journalisme' => 'Journalisme', 
                        'Bandes dessinées' => 'Bandes dessinées', 
                        'Manga' => 'Manga', 
                        'Comics' => 'Comics', 
                        'Autobiographie' => 'Autobiographie', 
                        'Autres' => 'Autres'
                    ]
                ]
            ])
            ->add('releaseDate', DateType::class, [
                'label' => 'Date de sortie du livre',
                'attr'  => [
                    "placeholder" => "Date de sortie du livre"
                ]
            ])
            ->add('poster', UrlType::class, [
                'label' => 'Affiche du livre',
                'attr'  => [
                    "placeholder" => "Affiche du livre"
                ]
            ])
            // ->add('rating', FloatType::class, [
            //     'label' => 'Note du livre',
            //     'attr'  => [
            //         "placeholder" => "Note du livre"
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
