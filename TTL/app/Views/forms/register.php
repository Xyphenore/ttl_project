<section class='container'>
    <div class='w-75 mx-auto py-5'>
        <div class='p-3 d-flex flex-column bg-light border border-secondary rounded-3'>
            <h1 class='fs-2 pb-3'>Inscription</h1>

            <?= service('validation')->listErrors() ?>
            <form method="post" action="<?= esc(base_url('register')) ?>" id="register_form" accept-charset='utf-8'>
                <?= csrf_field() ?>

                <div class='row g-3'>
                    <div class="form-group pb-2 col-lg-6">
                        <label for='email' class="form-label">Adresse email</label>
                        <input type='email' name='email' class="form-control" id="email" placeholder="Entrer votre adresse email"/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='pseudo' class='form-label'>Pseudo</label>
                        <input type='text' name='pseudo' id='pseudo' class='form-control' placeholder='Entrer votre pseudo'/>
                    </div>
                </div>

                <div class='row g-3'>
                    <div class='form-group pb-2 col-lg-6'>
                        <label for='pass' class='form-label'>Mot de passe</label>
                        <input type='password' name='pass' id="pass" class="form-control" placeholder="Entrer le mot de passe"/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='confirm' class='form-label'>Confirmation du mot de passe</label>
                        <input type='password' name='confirm' id='confirm' class='form-control' placeholder='Confirmer le mot de passe'/>
                    </div>
                </div>

                <div class='row g-3'>
                    <div class='form-group pb-2 col-lg-6'>
                        <label for='nom' class='form-label'>Nom</label>
                        <input type='text' name='nom' id='nom' class='form-control' placeholder='Entrer votre nom'/>
                    </div>

                    <div class='form-group pb-2 col-lg-6'>
                        <label for='prenom' class='form-label'>Prénom</label>
                        <input type='text' name='prenom' id='prenom' class='form-control' placeholder='Entrer votre prénom'/>
                    </div>
                </div>
            </form>

            <div class="btn-toolbar mx-auto" role="toolbar">
                <button type='submit' class='btn btn-dark mx-sm-5' value="S'inscrire" name='submit' form='register_form'>
                    S'inscrire
                </button>

                <a href="<?= esc(base_url('connexion')) ?>" role='button' class='btn btn-secondary mx-sm-5'>
                    Connexion
                </a>
            </div>
        </div>
    </div>
</section>