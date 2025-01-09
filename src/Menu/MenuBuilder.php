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
        $manager = $this->isGranted('ROLE_MANAGER');

        $menu = $this->factory->createItem('root', ['attributes' => ['class' => 'xxx']]);

        $menu->addChild('Accueil', ['route' => 'app_home']);

        if($manager) {

            if($this->isGranted('ROLE_ENSHROUDED')) {
                $menu->addChild('Enshrouded');

                $menu['Enshrouded']->addChild('Carte interactive');
                $menu['Enshrouded']['Carte interactive']->addChild('Catégories', ['uri' => 'app_home']);
                $menu['Enshrouded']['Carte interactive']->addChild('Marqueurs', ['route' => 'app_home']);
                $menu['Enshrouded']['Carte interactive']->addChild('Icônes', ['uri' => 'app_home']);

                $menu['Enshrouded']->addChild('Objets');
                $menu['Enshrouded']['Objets']->addChild('Tous les objets', ['uri' => 'app_home']);
                $menu['Enshrouded']['Objets']->addChild('Catégories', ['uri' => 'app_home']);

                $menu['Enshrouded']->addChild('Personnages', ['uri' => 'app_home']);

                $menu['Enshrouded']->addChild('Recettes');
                $menu['Enshrouded']['Recettes']->addChild('Toutes les recettes', ['uri' => 'app_home']);
                $menu['Enshrouded']['Recettes']->addChild('Catégories', ['uri' => 'app_home']);
                $menu['Enshrouded']['Recettes']->addChild('Sources', ['uri' => 'app_home']);
            }

            if($this->isGranted('ROLE_ONCEHUMAN')) {
                $menu->addChild('Once Human');

                $menu['Once Human']->addChild('Spécialisations', ['uri' => 'app_home']);
            }

            if($this->isGranted('ROLE_PALIA')) {
                $menu->addChild('Palia');

                $menu['Palia']->addChild('Objets');
                $menu['Palia']['Objets']->addChild('Tous les objets', ['uri' => 'app_home']);
                $menu['Palia']['Objets']->addChild('Catégories', ['uri' => 'app_home']);

                $menu['Palia']->addChild('Options');
                $menu['Palia']['Options']->addChild('Compétences', ['uri' => 'app_home']);
                $menu['Palia']['Options']->addChild('Localisations', ['uri' => 'app_home']);
                $menu['Palia']['Options']->addChild('Monnaies', ['uri' => 'app_home']);

                $menu['Palia']->addChild('Personnages');
                $menu['Palia']['Personnages']->addChild('Tous les personnages', ['uri' => 'app_home']);
                $menu['Palia']['Personnages']->addChild('Groupes', ['uri' => 'app_home']);

                $menu['Palia']->addChild('Recettes', ['uri' => 'app_home']);
            }

            if($this->isGranted('ROLE_ADMIN')) {
                $menu->addChild('Administration');

                $menu['Administration']->addChild('Utilisateurs', ['route' => 'app_admin_user_index']);
            }

        }

        $menu->addChild('Déconnexion', ['route' => 'app_logout']);

        return $menu;
    }
}
