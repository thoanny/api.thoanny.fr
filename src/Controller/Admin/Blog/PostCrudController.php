<?php

namespace App\Controller\Admin\Blog;

use App\Admin\Field\EditorJsField;
use App\Entity\Blog\Post;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[AdminRoute(path: '/blog/posts', name: 'blog_post')]
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['publishedAt' => 'DESC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $previewPost = Action::new('previewPost', 'Prévisualiser', 'fas fa-eye')
            ->linkToUrl(fn (Post $post) => "https://thoanny.fr/{$post->getSlug()}")
            ->setHtmlAttributes(['target' => '_blank'])
            ->displayIf(static fn (Post $post): bool => $post->getStatus() === 'published')
        ;

        return $actions
            ->add(Crud::PAGE_INDEX, $previewPost)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            FormField::addColumn(9),

            TextField::new('title', 'Titre'),
            TextareaField::new('excerpt', 'Extrait')->hideOnIndex(),
            EditorJsField::new('content', 'Contenu'),

            FormField::addFieldset('SEO'),
            BooleanField::new('hasSeoTitle', 'Titre SEO')->renderAsSwitch(false)->onlyOnIndex(),
            BooleanField::new('hasSeoDescription', 'Description SEO')->renderAsSwitch(false)->onlyOnIndex(),
            BooleanField::new('hasSeoKeywords', 'Mots-clés SEO')->renderAsSwitch(false)->onlyOnIndex(),
            TextField::new('seoTitle', 'Titre')->hideOnIndex(),
            TextareaField::new('seoDescription', 'Description')->hideOnIndex(),
            TextField::new('seoKeywords', 'Mots-clés')->hideOnIndex(),

            FormField::addColumn(3),

            DateTimeField::new('publishedAt', 'Publié le'),
            ChoiceField::new('status', 'Statut')->setChoices([
                'Brouillon' => 'draft',
                'Publié' => 'published'
            ]),

            FormField::addFieldset('Taxonomies'),
            AssociationField::new('categories', 'Catégories')->hideOnIndex()->setRequired(true),
            AssociationField::new('tags', 'Tags')->hideOnIndex(),

            FormField::addFieldset('Illustration'),
            TextField::new('imageCaption', 'Légende')->hideOnIndex(),
            TextField::new('imageFile', 'Illustration')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName', 'Illustration')->setBasePath('/uploads')->onlyOnIndex(),
        ];
    }
}
