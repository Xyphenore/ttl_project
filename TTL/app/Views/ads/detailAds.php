<!-- Affichage du détail d'une annonce publiée
Doit etre visible par tout utilisateurs connectés ou non 
Les boutons d'action de modification n'apparaissent que pour le propriétaire de l'annonce 
Le bouton pour contacter le propriétaire ne doit pas apparaitre pour le propriétaire de l'annonce -->
<!-- TODO debug à virer -->
ads/detailAds.php<br/>
<hr />
<h2><?= esc($ads['A_titre']) ?></h2><br/>
<hr />
id : <?= esc($ads['A_idannonce']) ?><br />
Loyer : <?= esc($ads['A_cout_loyer']) ?> €<br />
Charges : <?= esc($ads['A_cout_charges']) ?>€<br />
Type chauffage : <?= esc($ads['A_type_chauffage']) ?><br />
Superficie : <?= esc($ads['A_superficie']) ?>m<sup>2</sup><br />
Description : <?= esc($ads['A_description']) ?><br />
Adresse : <?= esc($ads['A_adresse']) ?><br />
Ville : <?= esc($ads['A_ville']) ?><br />
CP : <?= esc($ads['A_CP']) ?><br />
Type energie : <?= esc($ads['E_idenergie']) ?><br />
Date de création : <?= esc($ads['A_date_creation']) ?><br />
Date modification : <?= esc($ads['A_date_modification']) ?><br />
Mail créateur : <?= esc($ads['U_mail']) ?><br />
Etat de l'annonce : <?= esc($ads['A_etat']) ?><br />
Photo : <br />
<div>
    <?php if (!empty($photo) && is_array($photo)) : ?>

        <?php foreach ($photo as $photo_item) : ?>
            <p><a title="Voir la photo" href="/photos/<?= esc($photo_item['P_idphoto'], 'url') ?>"> 
            <?php echo' <img src = "data:image/png;base64,' . base64_encode($photo_item['P_data']) . '" width = "300px" height = "300px"/>'?> </a></p>
            
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Pas de photos</h3>

        <p>Impossible d'afficher les photos, ou aucune photo</p>

    <?php endif ?>
    <br />
    <br />

    <br />
    <form action="contact" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="idAnnonce" value=<?= esc($ads['A_idannonce']) ?> /><br />

        <label for="contact">Contacter l'annonceur :</label>
        <textarea name="message" cols="45" rows="4">Bonjour , merci de me donner plus d'information sur le bien proposé</textarea><br />

        <input type="submit" name="act" value="Contacter" />
    </form>