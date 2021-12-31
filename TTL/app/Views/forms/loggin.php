<h2><?= esc($title) ?></h2>

<?= service('validation')->listErrors() ?>
<form action="/forms/loggin" method="post">
    <?= csrf_field() ?>

    <label for="pseudo">pseudo</label>
    <input type="text" name="pseudo" /><br />

    <label for="pass">password</label>
    <input type="password" name="pass" /><br />
   
    <input type="submit" name="submit" value="Connexion" />
</form>