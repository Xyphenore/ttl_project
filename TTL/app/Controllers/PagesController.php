<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Contrôleur pour les routes /pages/
 * @extends BaseController
 * @see /App/Config/Routes.php
 * @version 1.0
 */
class PagesController extends BaseController
{
    /**
     * Fonction appelée lors de l'accès à l'accueil du site.
     * Elle retourne le nom de la page d'accueil du site
     * @version 1.0
     * @return string
     */
    public function index(): string
    {
        return view('index');
    }

    /**
     * Affiche la page passée en paramètre, si aucun paramètre passé, alors on affiche la page d'accueil(index)
     * @throws PageNotFoundException Si le paramètre passé ne correspond à aucune page qui se trouve dans le dossier /Views/pages/
     * @param $page string
     * @see /Views/pages/
     * @return void
     *@version 1.0
     */
    public function view(string $page = 'index'): void
    {
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        // Affichage de la page
        echo view('templates/header', ['title' => 'TrouveTonLogement - Accueil']);

        //echo '->'.APPPATH . 'Views/pages/' . $page . '.php<br/>';

        echo view('pages/' . $page);
        echo view('templates/footer');
    }
}