<h2><?= esc($tete) ?></h2>

<div>
    <?php if (!empty($user) && is_array($user)) : ?>

        <?php foreach ($user as $user_item) : ?>

            <div style="border: thin solid blue">
                <p><a title="Voir le profil" href="/users/<?= esc($user_item['U_pseudo'], 'url') ?>"> <?= esc($user_item['U_pseudo']) ?> </a><br />
                    <sup> <?= esc($user_item['count']) ?> annonce(s) publiées</sup>
                </p>
                <?= esc($user_item['U_nom']) ?> <?= esc($user_item['U_prenom']) ?><br />
                Mail : <?= esc($user_item['U_mail']) ?><br />
                Mot de passe : <?= esc($user_item['U_mdp']) ?><br />
                <?php if ($user_item['U_bloc'] == 1) : ?>
                    Bloqué
                <?php else : ?>
                    Libre
                <?php endif ?>
                <br />


                <form action="adminUserAction" method="post">
                    <?= csrf_field() ?>
                    <input type="text" name="idUser" value="<?= esc($user_item['U_mail']) ?>" />

                    <?php if ($user_item['U_bloc'] == 1) : ?>
                        <input type="submit" name="adminAct" value="unblocUser" class='btn btn-success text-white mb-1' />
                    <?php else : ?>
                        <input type="submit" name="adminAct" value="blocUser" class='btn btn-warning text-white mb-1' />
                    <?php endif ?>
                    <input type="submit" name="adminAct" value="editUser" class='btn btn-success text-white mb-1' />
                    <input type="submit" name="adminAct" value="delUser" class='btn btn-danger text-white mb-1' />
                    <input type="submit" name="adminAct" value="mailUser" class='btn btn-dark text-white mb-1' />
                </form>
            <?php endforeach; ?>



            </div>
        <?php else : ?>

            <h3>Pas d'utilisateurs</h3>

            <p>Impossible d'afficher les utilisateurs inscrits, ou aucun utilisateur n'est inscrit</p>

        <?php endif ?>
</div>