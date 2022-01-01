
<hr/>
<h2><?= esc($ads['A_titre']) ?></h2>
<hr/>
id : <?= esc($ads['A_idannonce']) ?><br/>
Loyer : <?= esc($ads['A_cout_loyer']) ?> €<br/>
Charges : <?= esc($ads['A_cout_charges']) ?>€<br/>
Type chauffage : <?= esc($ads['A_type_chauffage']) ?><br/>
Superficie : <?= esc($ads['A_superficie']) ?>m<sup>2</sup><br/>
Description : <?= esc($ads['A_description']) ?><br/>
Adresse : <?= esc($ads['A_adresse']) ?><br/>
Ville : <?= esc($ads['A_ville']) ?><br/>
CP : <?= esc($ads['A_CP']) ?><br/>
Type energie : <?= esc($ads['E_idenergie']) ?><br/>
Date de création : <?= esc($ads['A_date_creation']) ?><br/>
Date modification : <?= esc($ads['A_date_modification']) ?><br/>
Mail créateur : <?= esc($ads['U_mail']) ?><br/>
Etat de l'annonce : <?= esc($ads['A_etat']) ?><br/>
Photo : <br/>
<br/>
<br/>

<br/>
<form action="/ads/action" method="post">
    <?= csrf_field() ?>  
    <input type="hidden" name="id" value=<?= esc($ads['A_idannonce']) ?> /><br />

    <input type="submit" name="act" value="Archiver" />
    <input type="submit" name="act" value="Publier" />
    <input type="submit" name="act" value="Brouillon" />
    <input type="submit" name="act" value="Modifier" />
    <input type="submit" name="act" value="Supprimer" />
</form>

