<!-- Affichage du détail d'une annonce publiée
Doit etre visible par tout utilisateurs connectés ou non 
Les boutons d'action de modification n'apparaissent que pour le propriétaire de l'annonce 
Le bouton pour contacter le propriétaire ne doit pas apparaitre pour le propriétaire de l'annonce -->
<!-- TODO debug à virer -->
ads/detailAds.php<br />
<hr />
<h2><?= esc($ads['A_titre']) ?></h2>
<hr />

Loyer : <?php echo (esc($ads['A_cout_loyer'])) + (esc($ads['A_cout_charges'])) ?> €
<?php if (esc($ads['A_cout_charges']) > 0) : ?>
    dont <?= esc($ads['A_cout_charges']) ?>€ de charges<br />
<?php else : ?>
    <br />
<?php endif ?>

Chauffage <?= esc($ads['A_type_chauffage']) ?>
<?php if (esc($ads['A_type_chauffage']) === "Individuel") : ?>
    - <?= esc($ads['E_idenergie']) ?><br />
<?php else : ?>
    <br />
<?php endif ?>

<?= esc($ads['T_type']) ?> de <?= esc($ads['A_superficie']) ?>m <sub>2</sub><br />
Description :<br>
<div>
    <?= esc($ads['A_description']) ?>
</div>
Logement situé : <br />
<?= esc($ads['A_adresse']) ?><br />
<?= esc($ads['A_CP']) ?> <?= esc($ads['A_ville']) ?><br />
Créé le <?= esc($ads['A_date_creation']) ?><br />
Dernière modification le <?= esc($ads['A_date_modification']) ?><br />
<br />
<div>
    <?php if (!empty($photo) && is_array($photo)) : ?>

        <?php foreach ($photo as $photo_item) : ?>
            <p><a title="Voir la photo" href="/photos/<?= esc($photo_item['P_idphoto'], 'url') ?>">
                    <?php echo ' <img src = "data:image/png;base64,' . base64_encode($photo_item['P_data']) . '" width = "300px" height = "300px"/>' ?> </a></p>

        <?php endforeach; ?>

    <?php else : ?>
        <h3>Aucune photos</h3>
    <?php endif ?>
    <br />
 
    <?php $session = session(); ?>
    <?php if (!empty($session->islogedIn)) : ?>
        <form action="contact" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="idAnnonce" value=<?= esc($ads['A_idannonce']) ?> /><br />

            <label for="contact">Contacter l'annonceur :</label>
            <textarea name="message" placeholder="" cols="45" rows="4">
            Bonjour , merci de me donner plus d'information sur le bien proposé.
        </textarea><br />
            <input type="submit" name="act" value="Contacter" />
        </form>
    <?php else : ?>
        Vous devez être connecté pour contacter un propriétaire </br>
        <a class="nav-link" href=<?= esc(base_url('login')) ?>>Se connecter</a>
    <?php endif ?>