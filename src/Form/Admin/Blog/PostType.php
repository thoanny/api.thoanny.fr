<?php

namespace App\Form\Admin\Blog;

use App\Entity\Blog\Category;
use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Form\Type\EditorJsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content', EditorJsType::class)
            ->add('status')
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('seoTitle')
            ->add('seoDescription')
            ->add('seoKeywords')
            ->add('imageName')
            ->add('imageCaption')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
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
