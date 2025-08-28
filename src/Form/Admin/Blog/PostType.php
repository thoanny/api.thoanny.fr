<?php

namespace App\Form\Admin\Blog;

use App\Entity\Blog\Category;
use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Form\Type\EditorJsType;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('excerpt', TextareaType::class, [
                'required' => false,
                'label' => 'Extrait',
            ])
            ->add('content', EditorJsType::class, [
                'label' => 'Contenu',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Brouillon' => 'draft',
                    'Publié' => 'published'
                ],
                'label' => 'Statut',
            ])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Publié le',
            ])
            ->add('seoTitle', TextType::class, [
                'required' => false,
                'label' => 'Titre'
            ])
            ->add('seoDescription', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
            ])
            ->add('seoKeywords', TextType::class, [
                'required' => false,
                'label' => 'Mots-clés',
            ])
            ->add('imageCaption', TextType::class, [
                'required' => false,
                'label' => 'Légende',
            ])
            ->add('categories', CategoryAutocompleteField::class, [
                'label' => 'Catégories',
                'multiple' => true
            ])
            ->add('tags', TagAutocompleteField::class, [
                'label' => 'Mots-clés',
                'multiple' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'help' => '1200px'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
