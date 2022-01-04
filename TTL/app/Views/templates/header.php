<?php
helper('html');

echo doctype();
if (empty($title)) {
    $title = "sans titre";
}

// Entête HTML
echo '<html lang="fr"><head><title>' . esc($title) . '</title>';

// Chargement de la feuille de style BootStrap
echo '<link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous">';

echo '</head>';

// Corps
echo '<body class="d-flex flex-column min-vh-100">';

// Barre de navigation commune à toutes les pages
/**
 * @see BootStrap : https://getbootstrap.com/docs/5.1/components/navbar/
 */
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-xl">';

echo '<a class="navbar-brand" href="' . esc(base_url()) . '">TrouveTonLogement</a>';

echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerNavBar"
                aria-controls="headerNavBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>';

echo '<div class="collapse navbar-collapse" id="headerNavBar">';
echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <button class="btn btn-sm btn-outline-secondary">
                            <a class="nav-link" href="' . esc(base_url('ads/create')) . '">+ Ajouter une annonce</a>
                        </button>
                    </li>
                 </ul>';

echo '<ul class="navbar-nav mb-2 mb-lg-0 d-flex">';

echo '<li class="nav-item">
<a class="nav-link" href="' . esc(base_url('allAds')) . '">Toutes les annonces</a>
</li>';

// La partie suivante dépend si on est connecté ou non
// TODO : Déplacer la récupération de la session dans le controller de la page
if (empty(session()->isLoogedIn)) {
    echo '<li class="nav-item">
            <a class="nav-link" href="' . esc(base_url('loggin')) . '">Se connecter</a>
        </li>';
} else {
    echo '<li class="nav-item">
            <a class="nav-link" href="' . esc(base_url('dashboard')) . '">Mon compte</a>
        </li>';
        
        echo '<li class="nav-item">
        <a class="nav-link" href="' . esc(base_url('allMessages')) . '">Messages</a>
        </li>';

        echo '<li class="nav-item">
        <a class="nav-link" href="' . esc(base_url('allAds')) . '">Mes annonces</a>
        </li>';

        echo '<li class="nav-item">';
    echo service('validation')->listErrors() .
        '<form action="' . esc(base_url('deconnexion')) . '" method="post">';
    echo csrf_field();
    echo '<input type="submit" name="submit" value="Déconnexion" class="btn btn-secondary"/>
        </form>
    </li>';
}
//<a class='nav-link' href="' . esc(base_url('forms/logout')) . '">Déconnexion</a>

echo '</ul>';

echo '</div> </div> </nav> <section class="bg-white">';


