
<!-- TODO debug à virer -->
forms/register.php<br/>
<h2><?= esc($title) ?></h2>

<?= service('validation')->listErrors() ?>
<form action="register" method="post">
    <?= csrf_field() ?>

    <label for="email">email</label>
    <input type="email" name="email" /><br />

    <label for="pass">password</label>
    <input type="password" name="pass" /><br />

    <label for="confirm">password</label>
    <input type="password" name="confirm" /><br />

    <label for="pseudo">pseudo</label>
    <input type="text" name="pseudo" /><br />

    <label for="nom">nom</label>
    <input type="text" name="nom" /><br />

    <label for="prenom">prenom</label>
    <input type="text" name="prenom" /><br />
    <input type="submit" name="submit" value="s'inscrire" />
</form>