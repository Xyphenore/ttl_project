<!-- Affichage de toutes les annonces publiées par un utilisateur
Doit etre visible par tout utilisateur connecté ou non -->
<!-- TODO debug à virer -->
ads/userAds.php<br/>
<h2><?= esc($tete) ?></h2>
<div>
    <?php if (!empty($ads) && is_array($ads)) : ?>

        <?php foreach ($ads as $ads_item) : ?>
            <p><a title="Voir le détail" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>">Bouton annonce</a><br/>
            <?= esc($ads_item['A_titre']) ?> - <?= esc($ads_item['A_etat']) ?></p>
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas d'annonce</h3>

        <p>Impossible d'afficher les annonces, ou aucune annonce</p>

    <?php endif ?>
</div>