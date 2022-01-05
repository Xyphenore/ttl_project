<h2><?= esc($user['U_pseudo']) ?></h2>

<h3>Les annonces publiées par <?= esc($user['U_pseudo']) ?> :</h3>
<?php $session = session(); ?>
<?php if ($session->isAdmin) : ?>
    <form action="<?= esc(base_url('adminUserAction')) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="idUser" value="<?= esc($user['U_mail']) ?>" />
        <input type="hidden" name="pseudoUser" value="<?= esc($user['U_pseudo']) ?>" />

        <?php if ($user['U_bloc'] == 1) : ?>
            <input type="submit" name="adminAct" value="unblocUser" class='btn btn-success text-white mb-1' />
        <?php else : ?>
            <input type="submit" name="adminAct" value="blocUser" class='btn btn-warning text-white mb-1' />
        <?php endif ?>
        <input type="submit" name="adminAct" value="editUser" class='btn btn-success text-white mb-1' />
        <input type="submit" name="adminAct" value="delUser" class='btn btn-danger text-white mb-1' />
        <input type="submit" name="adminAct" value="mailUser" class='btn btn-dark text-white mb-1' />
    </form>
<?php endif ?>


<!-- Div principal -->
<div style="border: thin solid black">
    <?php if (!empty($ads) && is_array($ads)) : ?>

        <?php foreach ($ads as $ads_item) : ?>

            <!-- Div d'une annonce -->
            <div style="border: thin solid blue">

                <!-- Titre et Lien vers le détail de l'annonce -->
                <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>">
                    <strong><?= esc($ads_item['A_titre']) ?></strong></a>

                <!-- Div de gauche -->
                <div>
                    <!-- Photo principale de l'annonce -->
                    <?php if (!empty($ads_item['P_idphoto'])) : ?>
                        <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '"width ="100px" height ="80px"/>' ?><br />
                    <?php else : ?>
                        <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?><br />
                    <?php endif ?>


                </div><!-- fin div de gauche -->

                <!-- Div de droite -->
                <div>

                    <!-- Montant du loyer charges inclues -->
                    <?php echo (esc($ads_item['A_cout_loyer'])) + (esc($ads_item['A_cout_charges'])) ?> € <em>tcc</em><br />

                    <!-- Type et surface -->
                    <?= esc($ads_item['T_type']) ?> - <?= esc($ads_item['A_superficie']) ?>m<sup>2</sup><br />

                    <!-- Code postal et ville -->
                    <?= esc($ads_item['A_CP']) ?> <?= esc($ads_item['A_ville']) ?><br />

                </div><!-- fin div de droite -->

                Créée le : <?= esc($ads_item['A_date_creation']) ?><br />
                Editée le : <?= esc($ads_item['A_date_creation']) ?><br />
                <?php $session = session(); ?>
                <?php if ($session->isAdmin) : ?>
                    <form action="<?= esc(base_url('adminAdAction')) ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="idUser" value="<?= esc($user['U_mail']) ?>" />
                        <input type="hidden" name="pseudoUser" value="<?= esc($user['U_pseudo']) ?>" />
                        <input type="hidden" name="idAd" value="<?= esc($ads_item['A_idannonce']) ?>" />

                        <?php if ($ads_item['A_etat'] === 'Bloc') : ?>
                            <input type="submit" name="adminAct" value="unblocAd" class='btn btn-success text-white mb-1' />
                        <?php else : ?>
                            <input type="submit" name="adminAct" value="blocAd" class='btn btn-warning text-white mb-1' />
                        <?php endif ?>
                        <input type="submit" name="adminAct" value="editAd" class='btn btn-success text-white mb-1' />
                        <input type="submit" name="adminAct" value="delAd" class='btn btn-danger text-white mb-1' />
                    </form>
                <?php endif ?>

            </div><!-- fin div de l'annonce -->
        <?php endforeach; ?>
    <?php else : ?>
        <h3>Aucune annonce</h3>
        <p>Aucune annonce en ligne actuellement</p>

    <?php endif ?>
</div>
<!-- fin div principal -->