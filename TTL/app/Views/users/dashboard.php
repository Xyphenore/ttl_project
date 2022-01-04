<h2>Bienvenue sur votre tableau de bord, <?= esc($prenom) ?> </h2>
<hr/>

nombre d'annonce total<br/>
nombre d'annonce en ligne<br/>
nombre d'annonces archivée<br/>



<form action="/dashboard/action" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="pseudo" value=<?= esc($pseudo) ?> /><br />

        <input type="submit" name="act" value="Annonces" /><br/>
        <input type="submit" name="act" value="Messages" /><br/>
        <input type="submit" name="act" value="Paramètre" /><br/>
        <input type="submit" name="act" value="Supprimer" /><br/>
    </form>