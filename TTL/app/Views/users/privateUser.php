<h2><?= esc($user['U_pseudo']) ?></h2>
<!-- TODO debug à virer -->
users/privateUser.php<br/>
<?= esc($user['U_nom']) ?> <?= esc($user['U_prenom']) ?><br />
Mail : <?= esc($user['U_mail']) ?><br />
Mot de passe : <?= esc($user['U_mdp']) ?><br />

<h3>Les annonces publiées par <?= esc($user['U_prenom']) ?> :</h3>
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