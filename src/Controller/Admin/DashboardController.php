<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Blog\CategoryCrudController as BlogCategoryCrudController;
use App\Controller\Admin\Blog\PostCrudController as BlogPostCrudController;
use App\Controller\Admin\Blog\TagCrudController as BlogTagCrudController;
use App\Controller\Admin\Enshrouded\ItemCrudController as EnshroudedItemCrudController;
use App\Controller\Admin\Enshrouded\ItemCategoryCrudController as EnshroudedItemCategoryCrudController;
use App\Controller\Admin\Enshrouded\NpcCrudController as EnshroudedNpcCrudController;
use App\Controller\Admin\Enshrouded\RecipeCategoryCrudController as EnshroudedRecipeCategoryCrudController;
use App\Controller\Admin\Enshrouded\RecipeCrudController as EnshroudedRecipeCrudController;
use App\Controller\Admin\Enshrouded\RecipeSourceItemCrudController as EnshroudedRecipeSourceItemCrudController;
use App\Controller\Admin\Enshrouded\RecipeSourceNpcCrudController as EnshroudedRecipeSourceNpcCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('api.thoanny.fr')
        ;
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addWebpackEncoreEntry('admin')
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Tableau de bord', 'fa-solid fa-gauge'),
            MenuItem::linkTo(UserCrudController::class, 'Utilisateurs', 'fa-solid fa-user-group'),
            MenuItem::linkTo(MembershipCrudController::class, 'T-potes', 'fa-solid fa-star'),
            MenuItem::section('Thoanny.fr'),
            MenuItem::linkTo(BlogPostCrudController::class, 'Articles', 'fa-solid fa-newspaper'),
            MenuItem::linkTo(BlogCategoryCrudController::class, 'Catégories', 'fa-solid fa-folder-open'),
            MenuItem::linkTo(BlogTagCrudController::class, 'Mots-clés', 'fa-solid fa-tags'),
            MenuItem::section('Enshrouded'),
            MenuItem::subMenu('Objets')->setSubItems([
                MenuItem::linkTo(EnshroudedItemCrudController::class, 'Objets'),
                MenuItem::linkTo(EnshroudedItemCategoryCrudController::class, 'Catégories'),
            ]),
            MenuItem::subMenu('Recettes')->setSubItems([
                MenuItem::linkTo(EnshroudedRecipeCrudController::class, 'Recettes'),
                MenuItem::linkTo(EnshroudedRecipeCategoryCrudController::class, 'Catégories'),
                MenuItem::linkTo(EnshroudedRecipeSourceItemCrudController::class, 'Sources (objets)'),
                MenuItem::linkTo(EnshroudedRecipeSourceNpcCrudController::class, 'Sources (persos)'),
            ]),
            MenuItem::linkTo(EnshroudedNpcCrudController::class, 'Personnages'),
        ];
    }

}
