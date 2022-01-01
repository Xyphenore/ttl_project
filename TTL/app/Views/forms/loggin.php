<h2><?= esc($data['title']) ?></h2>

<?= service('validation')->listErrors() ?>
<?php echo form_open('forms/loggin'); ?>
<label for='email'>Adresse mail</label>
<input type='email' name='email'/><br/>

<label for='pass'>Mot de passe</label>
<input type='password' name='pass'/><br/>

<input type='submit' name='submit' value='Connexion'/>
</form>

<a href="<?= esc($data['signin']) ?>">S'incrire</a>