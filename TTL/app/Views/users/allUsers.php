<h2><?= esc($title) ?></h2>
<div>
    <?php if (!empty($user) && is_array($user)) : ?>

        <?php foreach ($user as $user_item) : ?>
            <p><a title="Voir le profil" href="/users/<?= esc($user_item['U_pseudo'], 'url') ?>"> <?= esc($user_item['U_pseudo']) ?> </a>
             - X annonces publiées (en cours de développement)</p>

        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas d'utilisateurs</h3>

        <p>Impossible d'afficher les utilisateurs inscrits, ou aucun utilisateur n'est inscrit</p>

    <?php endif ?>
</div>