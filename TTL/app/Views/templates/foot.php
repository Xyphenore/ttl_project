<?php
echo '</section>';

// Affichage du footer
echo '<footer class="bd-footer bg-light mt-auto"> <div class="container py-3"> <div class="mb-3">';

// Affichage de la barre de navigation du footer
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                <div class="container-xl">
                    <a href="' . esc(base_url()) . '"
                       class="navbar-brand">
                        <img src="' . esc(base_url('favicon.ico')) . '" alt="Logo du site TTL">
                        <span class="fs-5">TrouveTonLogement</span>
                    </a>

                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#footerNavBar" aria-controls="footerNavBar" aria-expanded="false"
                            aria-label="Basculer la navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="footerNavBar">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="' . esc(base_url('cgu')) . '">CGU</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="' . esc(base_url('reglesDiffusion')) . '">Règle de diffusion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="' . esc(base_url('cookies')) . '">Cookies</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>';

echo '<hr>';

echo '<div class="mb-3">
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">
                        Ce site a été construit par :
                        <ul>
                            <li>DAVID Axel</li>
                            <li>GOI Suzy(Muriel)</li>
                        </ul>
                    </li>
                    <li class="mb-2">&copy; Tous droits réservés - DAVID Axel, GOI Suzy(Muriel) 2021</li>
                    <li class="mb-2">Version actuelle 1.0</li>
                </ul>
            </div>';

echo '</div></div></footer></body></html>';
