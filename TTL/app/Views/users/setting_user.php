<h2>Setting </h2>

<?php var_dump($data)?>

<?= service('validation')->listErrors() ?>
<?php echo form_open('users/setting_user'); ?>
    <label for='nom'>Nom</label>
    <input type='text' name='nom' value="<?php esc($data['nom'])?>"/><br/>

    <label for='prenom'>Prenom</label>
    <input type='text' name='prenom' value="<?php esc($data['prenom'])?>"/><br/>

    <hr/>

    <label for='pseudo'>Pseudo</label>
    <input type='text' name='pseudo' value="<?php esc($data['pseudo'])?>"/><br/>

    <label for='email'>Email</label>
    <input type='email' name='email' value="<?php esc($data['mail'])?>" disabled /><br/>

    <hr/>

    <label for='pass'>Nouveau mot de passe</label>
    <input type='password' name='pass'/><br/>

    <label for='confirm'>Confirmer le mot de passe</label>
    <input type='password' name='confirm'/><br/>

    <hr/>

    <label for='pass_now'>Mot de passe actuel</label>
    <input type='password' name='pass_now'/><br/>

    <input type='submit' name='submit' value='Valider'/>
</form>