<h2><?= esc($title) ?></h2>

<?= service('validation')->listErrors() ?>
<form action="/forms/logout" method="post">
    <?= csrf_field() ?>

    <input type="submit" name="submit" value="Déconnexion" />
</form>