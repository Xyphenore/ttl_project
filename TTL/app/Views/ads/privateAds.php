<!-- Affichage de toutes les annonces publiées ou non sur le site
n'est visible que par l'utilisateur les ayant créées -->

<h2><?= esc($title) ?></h2>
<div>
    <?php if (!empty($ads) && is_array($ads)) : ?>

        <?php foreach ($ads as $ads_item) : ?>
            <p><a title="Voir le détail" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>"> <?= esc($ads_item['A_idannonce']) ?> </a>
            <?= esc($ads_item['A_titre']) ?></p>

        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas d'annonce</h3>

        <p>Impossible d'afficher les annonces, ou aucune annonce</p>

    <?php endif ?>
</div>