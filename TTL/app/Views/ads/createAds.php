<!-- Formulaire de création d'une nouvelle annonce
Seul un utilisateur connecté peut y acceder -->

<h2><?= esc($tete) ?></h2>
<?= service('validation')->listErrors() ?>
<form action="/ads/create" method="post">
    <?= csrf_field() ?>

    <?php if (!empty($ads) && is_array($ads)) : ?>

        <label for="title">Titre :</label>
        <input type="text" name="title" minlength="3" maxlength="128" value="<?= esc($ads['title']) ?>" /><br />

        <label for="loyer">Loyer :</label>
        <input type="number" name="loyer" min="0" value="<?= esc($ads['loyer']) ?>" /><br />

        <label for="charges">Charges : </label>
        <input type="number" name="charges" min="0" value="<?= esc($ads['charges']) ?>" /><br />

        <p>Chauffage :</p>

        <div>
            <label for="collectif">Collectif</label>
            <input type="radio" name="chauffage" value="Collectif" <?php if ($ads['chauffage'] == 'Collectif') : ?> checked<?php endif ?>>

            <label for="individuel">Individuel</label>
            <input type="radio" name="chauffage" value="Individuel" <?php if ($ads['chauffage'] == 'Individuel') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="fuel">Fuel</label>
            <input type="radio" name="energie" value="Fuel" <?php if ($ads['energie'] == 'Fuel') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="solaire">Energie solaire</label>
            <input type="radio" name="energie" value="Solaire" <?php if ($ads['energie'] == 'Solaire') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="gaz">Gaz</label>
            <input type="radio" name="energie" value="Gaz" <?php if ($ads['energie'] == 'Gaz') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="electrique">Electrique</label>
            <input type="radio" name="energie" value="Electrique" <?php if ($ads['energie'] == 'Electrique') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="bois">Bois</label>
            <input type="radio" name="energie" value="Bois" <?php if ($ads['energie'] == 'Bois') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="autre">Autre</label>
            <input type="radio" name="energie" value="Autre" <?php if ($ads['energie'] == 'Autre') : ?> checked<?php endif ?>>
        </div>


        <p>Type logement :
            <label for="superficie">superficie :</label>
            <input type="number" name="superficie" min="10" max="9999" value="<?= esc($ads['superficie']) ?>" />
        </p>
        <div>
            <label for="T1">T1</label>
            <input type="radio" name="type" value="T1" <?php if ($ads['type'] == 'T1') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="T2">T2</label>
            <input type="radio" name="type" value="T2" <?php if ($ads['type'] == 'T2') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="T3">T3</label>
            <input type="radio" name="type" value="T3" <?php if ($ads['type'] == 'T3') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="T4">T4</label>
            <input type="radio" name="type" value="T4" <?php if ($ads['type'] == 'T4') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="T5">T5</label>
            <input type="radio" name="type" value="T5" <?php if ($ads['type'] == 'T5') : ?> checked<?php endif ?>>
        </div>
        <div>
            <label for="T6">T6</label>
            <input type="radio" name="type" value="T6" <?php if ($ads['type'] == 'T6') : ?> checked<?php endif ?>>
        </div>

        <label for="description">description :</label>
        <textarea name="description" cols="45" rows="4"><?= esc($ads['description']) ?></textarea><br />

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" maxlength="128" value="<?= esc($ads['adresse']) ?>" /><br />

        <label for="ville">Ville :</label>
        <input type="text" name="ville" maxlength="128" value="<?= esc($ads['ville']) ?>" /><br />

        <label for="cp">Code postal :</label>
        <input type="text" name="cp" min="01000" max="99999" value="<?= esc($ads['cp']) ?>" /><br />

    <?php else : ?>

        <label for="title">Titre :</label>
        <input type="text" name="title" minlength="3" maxlength="128" /><br />

        <label for="loyer">Loyer :</label>
        <input type="number" name="loyer" min="0" /><br />

        <label for="charges">Charges : </label>
        <input type="number" name="charges" min="0" /><br />

        <p>Chauffage :</p>

        <div>
            <label for="collectif">collectif</label>
            <input type="radio" name="chauffage" value="Collectif" checked>

            <label for="individuel">individuel</label>
            <input type="radio" name="chauffage" value="Individuel">
        </div>
        <div>
            <label for="fuel">Fuel</label>
            <input type="radio" name="energie" value="Fuel">
        </div>
        <div>
            <label for="solaire">Energie solaire</label>
            <input type="radio" name="energie" value="Solaire">
        </div>
        <div>
            <label for="gaz">Gaz</label>
            <input type="radio" name="energie" value="Gaz">
        </div>
        <div>
            <label for="electrique">Electrique</label>
            <input type="radio" name="energie" value="Electrique">
        </div>
        <div>
            <label for="bois">Bois</label>
            <input type="radio" name="energie" value="Bois">
        </div>
        <div>
            <label for="autre">Autre</label>
            <input type="radio" name="energie" value="Autre">
        </div>


        <p>Type logement :
            <label for="superficie">superficie :</label>
            <input type="number" name="superficie" min="10" max="9999" />
        </p>
        <div>
            <label for="T1">T1</label>
            <input type="radio" name="type" value="T1" checked>
        </div>
        <div>
            <label for="T2">T2</label>
            <input type="radio" name="type" value="T2">
        </div>
        <div>
            <label for="T3">T3</label>
            <input type="radio" name="type" value="T3">
        </div>
        <div>
            <label for="T4">T4</label>
            <input type="radio" name="type" value="T4">
        </div>
        <div>
            <label for="T5">T5</label>
            <input type="radio" name="type" value="T5">
        </div>
        <div>
            <label for="T6">T6</label>
            <input type="radio" name="type" value="T6">
        </div>

        <label for="description">description :</label>
        <textarea name="description" cols="45" rows="4"></textarea><br />

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" maxlength="128" /><br />

        <label for="ville">Ville :</label>
        <input type="text" name="ville" maxlength="128" /><br />

        <label for="cp">Code postal :</label>
        <input type="text" name="cp" min="01000" max="99999" /><br />

    <?php endif ?>

    <input type="submit" name="submit" value="Créer l'annonce" />
</form>