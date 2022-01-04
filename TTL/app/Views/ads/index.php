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

                <!-- Icone Si l'utilisateur est le propriétaire de l'annonce -->
                <?php if ($ads_item['U_mail'] === $iduser) : ?>
                    <?php echo '<img src="' . base_url('blue_star.png') . '"alt="Icone etoile bleue"/>' ?><br />

                <?php endif ?>

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

                Créée le : <?= esc($ads_item['A_date_creation']) ?> par
                <?php if (!empty($ads_item['U_pseudo'])) : ?>
                    <a title="Détail du profil" href="/users/<?= esc($ads_item['U_pseudo'], 'url') ?>"><strong><?= esc($ads_item['U_pseudo']) ?></strong></a>
                <?php endif ?><br />

                Editée le : <?= esc($ads_item['A_date_creation']) ?><br />
                <!-- TODO virer debug -->
                <sup>debug : <br />
                    <?= esc($ads_item['A_etat']) ?><br />
                    <?= esc($ads_item['A_idannonce']) ?><br /></sup>
            </div><!-- fin div de l'annonce -->
        <?php endforeach; ?>
    <?php else : ?>
        <h3>Aucune annonce</h3>
        <p>Aucune annonce en ligne actuellement</p>

    <?php endif ?>
</div>
<!-- fin div principal -->
