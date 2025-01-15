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

        $menu['OnceHuman']->addChild('Specializations', ['uri' => 'app_home', 'label' => 'Spécialisations']);

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

        // Administration

        $menu->addChild('Admin', ['label' => 'Administration'])->setDisplay($isAdmin);

        $menu['Admin']
            ->addChild('Users', ['route' => 'app_admin_user_index', 'label' => 'Utilisateurs'])
            ->setExtra('routes', ['app_admin_user_index', 'app_admin_user_edit', 'app_admin_user_show'])
        ;

        return $menu;
    }
}
