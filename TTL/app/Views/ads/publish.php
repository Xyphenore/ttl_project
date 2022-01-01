<h2><?= esc($title) ?></h2>
<?php


echo '<p>Récapitulatif de l\'annonce :</p><br/>';
?>


<?= service('validation')->listErrors() ?>
<form action="/ads/publish" method="post">
    <?= csrf_field() ?>

    <input type="submit" name="submit" value="Publier l'annonce" />
    <p>faire bouton pour modifier annonce</p>
    <p>faire bouton pour retour à son tableau de bord</p>

</form>