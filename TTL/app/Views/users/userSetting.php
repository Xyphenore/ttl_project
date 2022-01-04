<section class='container py-3'>
    <h1 class='fs-2 text-decoration-underline'>Paramètres du compte :</h1>

    <div class='px-5 pt-1'>
        <div class='border border-secondary rounded-3 p-4 mb-4'>
            <?php
            // Message de succès de l'opération
            if (!empty(session()->success_modify_identity)) {
                echo '<div class="bg-success border border-success rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Votre identité a été mise à jour</p>
                    </div>';
            }
            ?>

            <?php
            if (session()->get('id-form') === 'form-identity') {
                echo service('validation')->listErrors();
            }

            //  service('validation')->listErrors()
            ?>
            <form method="post" action="<?= esc(base_url('parametres')) ?>" class="">
                <?= csrf_field() ?>

                <input type="text" name="id-form" value="form-identity" hidden>

                <div class="row g-3">
                    <div class='form-group pb-2 col-lg-6'>
                        <label for='nom' class='form-label'>Nom</label>
                        <input type='text' name='nom' id='nom' class='form-control' value="<?= esc($data['nom']) ?>"/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='prenom' class='form-label'>Prénom</label>
                        <input type='text' name='prenom' id='prenom' class='form-control'
                               value="<?= esc($data['prenom']) ?>"/>
                    </div>
                </div>

                <hr/>

                <div class='row g-3'>
                    <div class='form-group pb-2 col-lg-6'>
                        <label for='email' class='form-label'>Email</label>
                        <input type='email' name='email' id='email' class='form-control-plaintext px-2 border'
                               value="<?= esc($data['mail']) ?>" readonly/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='pseudo' class='form-label'>Pseudo</label>
                        <input type='text' name='pseudo' id="pseudo" class='form-control'
                               value="<?= esc($data['pseudo']) ?>"/>
                    </div>
                </div>

                <hr/>

                <div class='form-group pb-3'>
                    <label for='pass' class='form-label'>Mot de passe actuel</label>
                    <input type='password' name='pass' id="pass" class='form-control' required/>
                </div>

                <input type='submit' name='submit' value='Valider' class="btn btn-success"/>
            </form>
        </div>

        <div class='border border-secondary rounded-3 p-4 mb-4'>
            <?php
            // Message de succès de l'opération
            if (!empty(session()->success_modify_pw)) {
                echo '<div class="bg-success border border-success rounded-3 pt-2 d-flex mb-2">
                            <p class="text-white mx-auto">Mot de passe modifié</p>
                    </div>';
            }
            ?>

            <?php
            if (session()->get('id-form') === 'form-password') {
                echo service('validation')->listErrors();
            }

            //  service('validation')->listErrors()
            ?>
            <form method='post' action="<?= esc(base_url('parametres')) ?>" class=''>
                <?= csrf_field() ?>

                <input type='text' name='id-form' value='form-password' hidden>

                <input type="email" name="email" id="email" class="form-control" required
                       value="<?= esc(session()->umail) ?>" hidden>

                <div class='row g-3'>
                    <div class='form-group pb-2 col-lg-6'>
                        <label for='new_pass' class="form-label">Nouveau mot de passe</label>
                        <input type='password' name='new_pass' id="new_pass" class="form-control" required/><br/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='confirm' class="form-label">Confirmer le mot de passe</label>
                        <input type='password' name='confirm' id="confirm" class="form-control" required/><br/>
                    </div>
                </div>

                <hr/>

                <div class='form-group pb-3'>
                    <label for='pass' class='form-label'>Mot de passe actuel</label>
                    <input type='password' name='pass' id='pass' class='form-control' required/>
                </div>

                <input type='submit' name='submit' value='Valider' class='btn btn-success'/>
            </form>
        </div>

        <?php
        if (session()->get('isAdmin') == false) {
            echo '<div class="row px-2">
                        <a href="' . esc(base_url('UserDelete')) . '" class="btn btn-danger border border-dark btn-lg fw-bold">Supprimer le compte</a>
                    </div>';
        }
        ?>

    </div>
</section>
