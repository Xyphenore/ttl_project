<!-- Affichage de toutes les annonces publiées ou non sur le site
n'est visible que par l'utilisateur les ayant créées -->

<h2><?= esc($tete) ?></h2>
<div>
    <div style="border: thin solid black">
        <?php if (!empty($ads) && is_array($ads)) : ?>

            <?php foreach ($ads as $ads_item) : ?>

                <!-- Div d'une annonce -->
                <div style="border: thin solid blue">

                    <!-- Titre et Lien vers le détail de l'annonce -->
                    <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>">
                        <strong><?= esc($ads_item['A_titre']) ?></strong></a>


                    <!-- Icone Si l'annonce a des messages -->
                    <?php if ($ads_item['count'] > 0) : ?>
                        <?php echo '<img src="' . base_url('msg.png') . '"alt="icone message"/>' ?><?= esc($ads_item['count']) ?> message(s) <br />
                    <?php endif ?>

                    <!-- Div de gauche -->
                    <div>
                        <!-- Photo principale de l'annonce -->
                        <?php if (!empty($ads_item['P_idphoto'])) : ?>
                            <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '"width ="100px" height ="80px"/>' ?><br />
                        <?php else : ?>
                            <?php echo '<img src="' . base_url('no_pic.jpg') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?><br />
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


                    <!-- TODO virer debug -->
                    <sup>debug : <?= esc($ads_item['A_etat']) ?> <?= esc($ads_item['A_idannonce']) ?><br /></sup>

                    <form action="actionAds" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value=<?= esc($ads_item['A_idannonce']) ?> /><br />
                        <input type="submit" name="act" value="Voir" />
                        <input type="submit" name="act" value="Archiver" />
                        <input type="submit" name="act" value="Publier" />
                        <input type="submit" name="act" value="Brouillon" />
                        <input type="submit" name="act" value="Modifier" />
                        <input type="submit" name="act" value="Supprimer" />
                    </form>
                </div><!-- fin div de l'annonce -->
            <?php endforeach; ?>
        <?php else : ?>
            <h3>Aucune annonce</h3>
            <p>Aucune annonce en ligne actuellement</p>

        <?php endif ?>
    </div>