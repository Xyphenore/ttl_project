<h2>Bienvenue sur votre tableau de bord, <?= esc($data['prenom']) ?> </h2>
<hr/>

<ul>
    <li><a href="<?= esc($data['annonces']) ?>">Vers vos annonces</a> </li>
    <li><a href="<?= esc($data['discussion']) ?>">Vers vos discussions</a></li>
    <li><a href="<?= esc($data['parametre']) ?>">Modifier les paramètres du compte</a></li>
    <li><a href="<?= esc($data['supprimer']) ?>">Supprimer votre compte</a> </li>
</ul>