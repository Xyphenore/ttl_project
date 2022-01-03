<h2><?= esc($tete) ?></h2>
<div>
    <?php if (!empty($user) && is_array($user)) : ?>

        <?php foreach ($user as $user_item) : ?>
            <p><a title="Voir le profil" href="/users/<?= esc($user_item['U_pseudo'], 'url') ?>"> <?= esc($user_item['U_pseudo']) ?> </a><br/>
           <sup> <?= esc($user_item['count']) ?> annonce(s) publiées</sup></p>

        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas d'utilisateurs</h3>

        <p>Impossible d'afficher les utilisateurs inscrits, ou aucun utilisateur n'est inscrit</p>

    <?php endif ?>
</div>