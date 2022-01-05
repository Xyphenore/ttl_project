<?php
// Affichage de toutes les annonces publiées sur le site
//Doit être visible par tous utilisateurs connectés ou non
?>
<!-- TODO retirer les border des div et mettre en forme dans le css -->

<h1 class="fs-2"><?= esc($tete) ?></h1>

<!-- Div principal -->
<div style="border: thin solid black">
    <?php
    if (!empty($ads) && is_array($ads)) : ?>

        <?php foreach ($ads as $ads_item) : ?>

            <!-- Div d'une annonce -->
            <div style="border: thin solid blue">
                <!-- Titre et Lien vers le détail de l'annonce -->
                <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>"><strong><?= esc($ads_item['A_titre']) ?></strong></a>

                <!-- Div de gauche -->
                <div>
                    <!-- Photo principale de l'annonce -->
                    <?php if (!empty($ads_item['P_idphoto'])) : ?>
                        <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '"width ="100px" height ="80px"/>' ?><br />
                    <?php else : ?>
                        <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?><br />
                    <?php endif ?>
                </div>
                 <!-- Montant du loyer charges inclues -->
                 <?php echo (esc($ads_item['U_mail']))  ?> <br />

            </div><!-- fin div de l'annonce -->
            <?php $session = session(); ?>
                <?php if ($session->isAdmin) : ?>
                    <form action="<?= esc(base_url('adminAdAction')) ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="idUser" value="<?= esc($ads_item['U_mail']) ?>" />
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

                
        <?php endforeach; ?>
    <?php else : ?>
        <h3>Aucune annonce</h3>
        <p>Aucune annonce en ligne actuellement</p>

    <?php endif ?>
</div>
<!-- fin div principal -->