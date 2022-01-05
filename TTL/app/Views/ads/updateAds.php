<!-- Formulaire de mise à jour d'une annonce existante
Seul un utilisateur connecté peut y acceder 
seul le proriétaire d'une annonce peut la modifier-->
<h2><?= esc($tete) ?></h2>
TODO : Les boutons d'action de modification ne doivent apparaitre que pour le propriétaire de l'annonce<br/>
Le bouton pour contacter le propriétaire ne doit pas apparaitre pour le propriétaire de l'annonce
<hr/>

<?= service('validation')->listErrors() ?>
<form action="updateAds" method="post">
    <?= csrf_field() ?>

    <label for="title">Titre :</label>
    <input type="text" name="title" minlength="3" maxlength="128" value="<?= esc($ads['A_titre']) ?>"/><br />

    <label for="loyer">Loyer :</label>
    <input type="number" name="loyer" min="0" value="<?= esc($ads['A_cout_loyer']) ?>"/><br />

    <label for="charges">Charges : </label>
    <input type="number" name="charges" min="0" value="<?= esc($ads['A_cout_charges']) ?>"/><br />

    <p>Chauffage :</p>

    <div>
        <label for="collectif">collectif</label>
        <input type="radio" name="chauffage" value="Collectif"  
        <?php if ($ads['A_type_chauffage'] == 'Collectif') : ?> checked<?php endif ?>>

        <label for="individuel">individuel</label>
        <input type="radio" name="chauffage" value="Individuel"  
        <?php if ($ads['A_type_chauffage'] == 'Individuel') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="fuel">Fuel</label>
        <input type="radio" name="energie" value="Fuel"
        <?php if ($ads['E_idenergie'] == 'Fuel') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="solaire">Energie solaire</label>
        <input type="radio" name="energie" value="Solaire"
        <?php if ($ads['E_idenergie'] == 'Solaire') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="gaz">Gaz</label>
        <input type="radio" name="energie" value="Gaz"
        <?php if ($ads['E_idenergie'] == 'Gaz') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="electrique">Electrique</label>
        <input type="radio" name="energie" value="Electrique"
        <?php if ($ads['E_idenergie'] == 'Electrique') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="bois">Bois</label>
        <input type="radio" name="energie" value="Bois"
        <?php if ($ads['E_idenergie'] == 'Bois') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="autre">Autre</label>
        <input type="radio" name="energie" value="Autre"
        <?php if ($ads['E_idenergie'] == 'Autre') : ?> checked<?php endif ?>>
    </div>

    
    <p>Type logement :
    <label for="superficie">superficie :</label>
    <input type="number" name="superficie" min="10" max="9999"value="<?= esc($ads['A_superficie']) ?>"/></p>
    <div>
        <label for="T1">T1</label>
        <input type="radio" name="type" value="T1"
        <?php if ($ads['T_type'] == 'T1') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="T2">T2</label>
        <input type="radio" name="type" value="T2"
        <?php if ($ads['T_type'] == 'T2') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="T3">T3</label>
        <input type="radio" name="type" value="T3"
        <?php if ($ads['T_type'] == 'T3') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="T4">T4</label>
        <input type="radio" name="type" value="T4"
        <?php if ($ads['T_type'] == 'T4') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="T5">T5</label>
        <input type="radio" name="type" value="T5"
        <?php if ($ads['T_type'] == 'T5') : ?> checked<?php endif ?>>
    </div>
    <div>
        <label for="T6">T6</label>
        <input type="radio" name="type" value="T6"
        <?php if ($ads['T_type'] == 'T6') : ?> checked<?php endif ?>>
    </div>

    <label for="description">description :</label>
    <textarea name="description" cols="45" rows="4" ><?= esc($ads['A_description']) ?></textarea><br />

    <label for="adresse">Adresse :</label>
    <input type="text" name="adresse" maxlength="128" value="<?= esc($ads['A_adresse']) ?>" /><br />

    <label for="ville">Ville :</label>
    <input type="text" name="ville" maxlength="128"  value="<?= esc($ads['A_ville']) ?>"/><br />

    <label for="cp">Code postal :</label>
    <input type="number" name="cp"  min="01000" max="99999" value="<?= esc($ads['A_CP']) ?>"/><br />


    <label for="photo">Photo :</label>
    <input type="text" name="titrePhoto" maxlength="128" /><br />
    <input type="file" name="photo" accept="image/png, image/jpeg">

    <input type="hidden" name="id" value="<?= esc($ads['A_idannonce']) ?>" /><br />
    <input type="submit" name="act" value="Annuler" /><input type="submit" name="act" value="Valider" />
</form>


