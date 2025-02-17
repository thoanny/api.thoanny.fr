<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuBuilder extends AbstractController
{
    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isManager = $this->isGranted('ROLE_MANAGER');
        $isEnshrouded = $this->isGranted('ROLE_ENSHROUDED');
        $isOnceHuman = $this->isGranted('ROLE_ONCEHUMAN');
        $isPalia = $this->isGranted('ROLE_PALIA');
        $isUser = $this->isGranted('ROLE_USER');

        $menu = $this->factory->createItem('root');

        $menu->addChild('Login', ['label' => 'Connexion', 'route' => 'app_login'])->setDisplay(!$isUser);
        $menu->addChild('Register', ['label' => 'Inscription', 'route' => 'app_register'])->setDisplay(!$isUser);

        // Enshrouded

        $menu->addChild('Enshrouded')->setDisplay($isManager && $isEnshrouded);

        $menu['Enshrouded']->addChild('Map', ['label' => 'Carte interactive']);
        $menu['Enshrouded']['Map']->addChild('Categories', ['uri' => 'app_home', 'label' => 'Catégories']);
        $menu['Enshrouded']['Map']->addChild('Markers', ['uri' => 'app_home', 'label' => 'Marqueurs']);
        $menu['Enshrouded']['Map']->addChild('Icons', ['uri' => 'app_home', 'label' => 'Icônes']);

        $menu['Enshrouded']->addChild('Objects', ['label' => 'Objets']);
        $menu['Enshrouded']['Objects']->addChild('All', ['uri' => 'app_home', 'label' => 'Tous les objets']);
        $menu['Enshrouded']['Objects']->addChild('Categories', ['uri' => 'app_home', 'label' => 'Catégories']);

        $menu['Enshrouded']->addChild('Characters', ['uri' => 'app_home', 'label' => 'Personnages']);

        $menu['Enshrouded']->addChild('Recipes', ['label' => 'Recettes']);
        $menu['Enshrouded']['Recipes']->addChild('All', ['uri' => 'app_home', 'label' => 'Tous les recettes']);
        $menu['Enshrouded']['Recipes']->addChild('Categories', ['uri' => 'app_home', 'label' => 'Catégories']);
        $menu['Enshrouded']['Recipes']->addChild('Sources', ['uri' => 'app_home']);

        // Once Human

        $menu->addChild('OnceHuman', ['label' => 'Once Human'])->setDisplay($isManager && $isOnceHuman);

        $menu['OnceHuman']
            ->addChild('Events', ['route' => 'app_admin_once_human_event_index', 'label' => 'Évènements'])
            ->setExtra('routes', [
                'app_admin_once_human_event_index',
                'app_admin_once_human_event_new',
                'app_admin_once_human_event_show',
                'app_admin_once_human_event_edit'
            ]);
        ;

        $menu['OnceHuman']
            ->addChild('Recipes', ['route' => 'app_admin_once_human_recipe_index', 'label' => 'Formules'])
            ->setExtra('routes', [
                'app_admin_once_human_recipe_index',
                'app_admin_once_human_recipe_new',
                'app_admin_once_human_recipe_show',
                'app_admin_once_human_recipe_edit'
            ]);
        ;

        $menu['OnceHuman']->addChild('Memetics', ['label' => 'Mimétiques']);
        $menu['OnceHuman']['Memetics']
            ->addChild('All', ['route' => 'app_admin_once_human_memetic_index', 'label' => 'Toutes les mimétiques'])
            ->setExtra('routes', [
                'app_admin_once_human_memetic_index',
                'app_admin_once_human_memetic_new',
                'app_admin_once_human_memetic_show',
                'app_admin_once_human_memetic_edit'
            ]);
        ;
        $menu['OnceHuman']['Memetics']
            ->addChild('Categories', ['route' => 'app_admin_once_human_memetic_category_index', 'label' => 'Catégories'])
            ->setExtra('routes', [
                'app_admin_once_human_memetic_category_index',
                'app_admin_once_human_memetic_category_new',
                'app_admin_once_human_memetic_category_show',
                'app_admin_once_human_memetic_category_edit'
            ]);
        ;

        $menu['OnceHuman']->addChild('Objects', ['label' => 'Objets']);
        $menu['OnceHuman']['Objects']
            ->addChild('All', ['route' => 'app_admin_once_human_item_index', 'label' => 'Tous les objets'])
            ->setExtra('routes', [
                'app_admin_once_human_item_index',
                'app_admin_once_human_item_new',
                'app_admin_once_human_item_show',
                'app_admin_once_human_item_edit'
            ]);
        ;
        $menu['OnceHuman']['Objects']
            ->addChild('Categories', ['route' => 'app_admin_once_human_item_category_index', 'label' => 'Catégories'])
            ->setExtra('routes', [
                'app_admin_once_human_item_category_index',
                'app_admin_once_human_item_category_new',
                'app_admin_once_human_item_category_show',
                'app_admin_once_human_item_category_edit'
            ]);
        ;

        $menu['OnceHuman']
            ->addChild('Scenarios', ['route' => 'app_admin_once_human_scenario_index', 'label' => 'Scénarios'])
            ->setExtra('routes', [
                'app_admin_once_human_scenario_index',
                'app_admin_once_human_scenario_new',
                'app_admin_once_human_scenario_show',
                'app_admin_once_human_scenario_edit'
            ]);
        ;

        $menu['OnceHuman']->addChild('Servers', ['label' => 'Serveurs']);
        $menu['OnceHuman']['Servers']
            ->addChild('All', ['route' => 'app_admin_once_human_server_index', 'label' => 'Tous les serveurs'])
            ->setExtra('routes', [
                'app_admin_once_human_server_index',
                'app_admin_once_human_server_new',
                'app_admin_once_human_server_show',
                'app_admin_once_human_server_edit'
            ]);
        ;
        $menu['OnceHuman']['Servers']
            ->addChild('Tags', ['route' => 'app_admin_once_human_server_tag_index', 'label' => 'Mots-clés'])
            ->setExtra('routes', [
                'app_admin_once_human_server_tag_index',
                'app_admin_once_human_server_tag_new',
                'app_admin_once_human_server_tag_show',
                'app_admin_once_human_server_tag_edit'
            ]);
        ;

        $menu['OnceHuman']->addChild('Specializations', ['label' => 'Spécialisations']);
        $menu['OnceHuman']['Specializations']
            ->addChild('All', ['route' => 'app_admin_once_human_specialization_index', 'label' => 'Toutes les spécialisations'])
            ->setExtra('routes', [
                'app_admin_once_human_specialization_index',
                'app_admin_once_human_specialization_new',
                'app_admin_once_human_specialization_show',
                'app_admin_once_human_specialization_edit'
            ]);
        ;

        $menu['OnceHuman']['Specializations']
            ->addChild('Groups', ['route' => 'app_admin_once_human_specialization_group_index', 'label' => 'Groupes de spécialisations'])
            ->setExtra('routes', [
                'app_admin_once_human_specialization_group_index',
                'app_admin_once_human_specialization_group_new',
                'app_admin_once_human_specialization_group_show',
                'app_admin_once_human_specialization_group_edit'
            ]);
        ;

        // Palia

        $menu->addChild('Palia')->setDisplay($isManager && $isPalia);

        $menu['Palia']->addChild('Objects');
        $menu['Palia']['Objects']->addChild('All', ['uri' => 'app_home', 'label' => 'Tous les objets']);
        $menu['Palia']['Objects']->addChild('Categories', ['uri' => 'app_home', 'label' => 'Catégories']);

        $menu['Palia']->addChild('Options');
        $menu['Palia']['Options']->addChild('Skills', ['uri' => 'app_home', 'label' => 'Compétences']);
        $menu['Palia']['Options']->addChild('Locations', ['uri' => 'app_home', 'label' => 'Localisations']);
        $menu['Palia']['Options']->addChild('Coins', ['uri' => 'app_home', 'label' => 'Monnaies']);

        $menu['Palia']->addChild('Characters', ['label' => 'Personnages']);
        $menu['Palia']['Characters']->addChild('All', ['uri' => 'app_home', 'label' => 'Tous les personnages']);
        $menu['Palia']['Characters']->addChild('Groups', ['uri' => 'app_home', 'label' => 'Groupes']);

        $menu['Palia']->addChild('Recipes', ['uri' => 'app_home', 'label' => 'Recettes']);

        // Revue de presse
        $menu->addChild('PressReview', ['label' => 'Revue de presse'])->setDisplay($isAdmin);

        $menu['PressReview']
            ->addChild('Posts', ['label' => 'Articles', 'route' => 'app_admin_press_review_post_index'])
            ->setExtra('routes', [
                'app_admin_press_review_post_index',
                'app_admin_press_review_post_new',
                'app_admin_press_review_post_show',
                'app_admin_press_review_post_edit',
                'app_admin_press_review_post_delete'
            ])
        ;
        $menu['PressReview']
            ->addChild('Categories', ['label' => 'Catégories', 'route' => 'app_admin_press_review_category_index'])
            ->setExtra('routes', [
                'app_admin_press_review_category_index',
                'app_admin_press_review_category_new',
                'app_admin_press_review_category_show',
                'app_admin_press_review_category_edit',
                'app_admin_press_review_category_delete'
            ])
        ;
        $menu['PressReview']
            ->addChild('Issues', ['label' => 'Éditions', 'route' => 'app_admin_press_review_issue_index'])
            ->setExtra('routes', [
                'app_admin_press_review_issue_index',
                'app_admin_press_review_issue_new',
                'app_admin_press_review_issue_show',
                'app_admin_press_review_issue_edit',
                'app_admin_press_review_issue_delete'
            ])
        ;
        $menu['PressReview']
            ->addChild('Tags', ['label' => 'Mots-clés', 'route' => 'app_admin_press_review_tag_index'])
            ->setExtra('routes', [
                'app_admin_press_review_tag_index',
                'app_admin_press_review_tag_new',
                'app_admin_press_review_tag_show',
                'app_admin_press_review_tag_edit',
                'app_admin_press_review_tag_delete'
            ])
        ;

        // Administration

        $menu->addChild('Admin', ['label' => 'Administration'])->setDisplay($isAdmin);

        $menu['Admin']
            ->addChild('Memberships', ['route' => 'app_admin_membership_index', 'label' => 'T-potes'])
            ->setExtra('routes', [
                'app_admin_membership_index',
                'app_admin_membership_new',
                'app_admin_membership_edit',
                'app_admin_membership_show'
            ])
        ;

        $menu['Admin']
            ->addChild('Users', ['route' => 'app_admin_user_index', 'label' => 'Utilisateurs'])
            ->setExtra('routes', ['app_admin_user_index', 'app_admin_user_edit', 'app_admin_user_show'])
        ;

        return $menu;
    }
}
