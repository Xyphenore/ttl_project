<?php
helper('html');

// Si on passe un tableau data contenant title alors il faut définir la variable title comme étant la valeur contenue dans la cellule de data
if (!empty($data['title'])) {
    $title = $data['title'];
}

echo doctype();

// Entête HTML
echo '<html lang="fr"><head><title>' . esc($title) . '</title>';

// Chargement de la feuille de style BootStrap
echo '<link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous">';

echo '</head>';

// Corps
echo '<body class="d-flex flex-column min-vh-100 bg-light">';

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

echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex">
        <li class="nav-item me-2 pb-2 pb-lg-0">
            <button class="btn btn-sm btn-primary" type="button">
                <a class="nav-link text-white" href="' . esc(base_url('createAds')) . '">+ Ajouter une annonce</a>
            </button>
        </li>
        
        <li class="nav-item">
            <button class="btn btn-sm btn-outline-secondary" type="button">
                <a class="nav-link text-white" href="' . esc(base_url('allAds')) . '">Toutes les annonces</a>
            </button>
        </li>
     </ul>';


echo '<ul class="navbar-nav mb-2 mb-lg-0 d-flex">';

// La partie suivante dépend si on est connecté ou non
// TODO : Déplacer la récupération de la session dans le controller de la page
if ( empty(session()->isLoogedIn) ) {
    echo '<li class="nav-item">
            <a class="nav-link text-white" href="' . esc(base_url('login')) . '">Se connecter</a>
        </li>';
}
else {
    echo '<li class="nav-item pb-2 pb-lg-0 me-2">
            <a class="nav-link text-white" href="' . esc(base_url('allMessages')) . '">Messages</a>
        </li>';

    echo '<li class="nav-item pb-2 pb-lg-0 me-2">
            <a class="nav-link text-white" href="' . esc(base_url('dashboard')) . '">Mon compte</a>
        </li>
        <li class="nav-item">';
    echo '<form action="' . esc(base_url('logout')) . '" method="post">';
    echo csrf_field();
    echo '<input type="submit" name="submit" value="Déconnexion" class="btn btn-secondary"/>
        </form>
    </li>';
}

echo '</ul>';

echo '</div> </div> </nav>';
