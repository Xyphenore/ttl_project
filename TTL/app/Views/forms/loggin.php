<h2><?= esc($title) ?></h2>

<?= service('validation')->listErrors() ?>
<form action="/forms/loggin" method="post">
    <?= csrf_field() ?>

    <label for="email">email</label>
    <input type="text" name="email" /><br />

    <label for="pass">password</label>
    <input type="password" name="pass" /><br />

    <input type="submit" name="submit" value="Connexion" />
</form>