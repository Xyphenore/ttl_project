<section class='container'>
    <div class='w-75 mx-auto py-5'>
        <div class='p-3 d-flex flex-column bg-light border border-secondary rounded-3'>
            <h1 class='fs-2 pb-3'>Récupération du mot de passe</h1>

            <?php
            // Affichage du message de succès de modification de mot de passe
            if (!empty(session()->fail_mail)) {
                echo '<div class="bg-danger border border-danger rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Le mail de récupération de mot de passe a été refusé par votre boite mail</p>
                    </div>';
            }
            ?>

            <?php
            // Affichage du message de succès de modification de mot de passe
            if (!empty(session()->fail_gen_pw)) {
                echo '<div class="bg-danger border border-danger rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Erreur interne impossible d\'effectuer \'action souhaitée</p>
                    </div>';
            }
            ?>

            <?= service('validation')->listErrors() ?>
            <form method="post" action="<?= esc(base_url('forgottenPassword')) ?>" id="forgotPW_form" accept-charset='utf-8'>
                <?= csrf_field() ?>

                <div class="form-group pb-2">
                    <label for='email' class="form-label">Adresse email</label>
                    <input type='email' name='email' class="form-control" id="email" placeholder="Entrer votre email"/>
                </div>

            </form>

            <div class="btn-toolbar mx-auto" role="toolbar">
                <button type='submit' class='btn btn-dark mx-sm-5' value='Récupérer' name='submit' form='forgotPW_form'>
                    Récupérer
                </button>

                <a href="<?= esc(base_url('login')) ?>" role='button' class='btn btn-secondary mx-sm-5'>
                    Connexion
                </a>
            </div>
        </div>
    </div>
</section>
