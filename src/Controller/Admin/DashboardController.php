<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Blog\CategoryCrudController;
use App\Controller\Admin\Blog\PostCrudController;
use App\Controller\Admin\Blog\TagCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
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
            ->setTitle('api.thoanny.fr');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Tableau de bord', 'fa-solid fa-gauge'),
            MenuItem::linkTo(MembershipCrudController::class, 'T-potes', 'fa-solid fa-star'),
            MenuItem::linkTo(UserCrudController::class, 'Utilisateurs', 'fa-solid fa-user-group'),
            MenuItem::section('Thoanny.fr'),
            MenuItem::linkTo(PostCrudController::class, 'Articles', 'fa-solid fa-newspaper'),
            MenuItem::linkTo(CategoryCrudController::class, 'Catégories', 'fa-solid fa-folder-open'),
            MenuItem::linkTo(TagCrudController::class, 'Mots-clés', 'fa-solid fa-tags'),
        ];
    }

}
