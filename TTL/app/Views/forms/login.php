<section class='container'>
    <div class='w-75 mx-auto py-5'>
        <div class='p-3 d-flex flex-column bg-light border border-secondary rounded-3'>
            <h1 class='fs-2 pb-3'>Connexion</h1>

            <?php
            // Affichage du message de succès de l'inscription
            if (!empty(session()->register_success)) {
                echo '<div class="bg-success border border-success rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Inscription validée</p>
                    </div>';
            }
            ?>


            <?= service('validation')->listErrors() ?>
            <form method="post" action="<?= esc(base_url('login')) ?>" id="login_form" accept-charset='utf-8'>
                <?= csrf_field() ?>

                <div class="form-group pb-2">
                    <label for='email' class="form-label">Adresse email</label>
                    <input type='email' name='email' class="form-control" id="email" placeholder="Entrer votre email"/>
                </div>

                <div class='form-group pb-2'>
                    <label for='pass' class='form-label'>Mot de passe</label>
                    <input type='password' name='pass' id="pass" class="form-control"
                           placeholder="Entrer votre mot de passe"/>
                </div>
            </form>

            <div class="btn-toolbar mx-auto" role="toolbar">
                <button type='submit' class='btn btn-dark mx-sm-5' value='Connexion' name='submit' form='login_form'>
                    Connexion
                </button>

                <a href="<?= esc(base_url('register')) ?>" role='button' class='btn btn-secondary mx-sm-5'>
                    S'inscrire
                </a>
            </div>
        </div>
    </div>
</section>
