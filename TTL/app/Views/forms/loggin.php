<h2><?= esc($data['title']) ?></h2>
<!-- TODO debug à virer -->
forms/login.php<br/>
<?= service('validation')->listErrors() ?>
<?php echo form_open('login'); ?> 
        <?= csrf_field() ?>
<label for='email'>Adresse mail</label>
<input type='email' name='email'/><br/>

<label for='pass'>Mot de passe</label>
<input type='password' name='pass'/><br/>

<input type='submit' name='submit' value='Connexion'/>
</form>

<a href="<?= esc($data['signin']) ?>">S'incrire</a>