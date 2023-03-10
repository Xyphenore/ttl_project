<!-- Formulaire de création d'une nouvelle annonce
Seul un utilisateur connecté peut y acceder -->


<section class="container py-3">
    <h1 class='fs-2'>Création d'une annonce</h1>

    <div class='px-5 pt-1'>
        <div class='border border-dark rounded-3 p-4'>
            <?= service('validation')->listErrors() ?>
            <form action="<?= esc(base_url('createAds')) ?>" method="post" class="">
                <?= csrf_field() ?>

                <?php if (!empty($ads) && is_array($ads)) : ?>

                    <div class='form-group pb-2'>
                        <label for="titre" class="form-label">Titre*</label>
                        <input type="text" name="titre" id="titre" class="form-control" minlength="3" maxlength="128"
                               required value="<?= esc($ads['titre']) ?>"/>
                    </div>

                    <div class='row g-3'>
                        <div class='form-group pb-2 col-md-6'>
                            <label for="loyer" class="form-label">Loyer*</label>
                            <div class="input-group">
                                <input type="number" name="loyer" id="loyer" class="form-control" min="0" required
                                       value="<?= esc($ads['loyer']) ?>"/>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>

                        <div class='form-group pb-2 col-md-6'>
                            <label for="charges" class="form-label">Charges</label>
                            <div class='input-group'>
                                <input type="number" name="charges" id="charges" class="form-control" min="0" 
                                       value="<?= esc($ads['charges']) ?>"/>
                                <span class='input-group-text'>€</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-2">
                        <label class="form-label me-3">Chauffage* : </label>

                        <div class="form-check form-check-inline">
                            <input type='radio' name='chauffage' id="collectif" class="form-check-input"
                                   value='Collectif' <?php if ($ads['chauffage'] == 'Collectif') : ?> checked<?php endif ?>>
                            <label for="collectif" class='form-check-label'>Collectif</label>
                        </div>

                        <div class='form-check form-check-inline'>
                            <input type='radio' name='chauffage' id="individuel" class="form-check-input"
                                   value='Individuel' <?php if ($ads['chauffage'] == 'Individuel') : ?> checked<?php endif ?>>
                            <label for="individuel" class='form-check-label'>Individuel</label>
                        </div>
                    </div>

                    <!-- TODO ne pas faire apparaitre cette partie si le chauffage est collectif -->
                    <!-- Section energie -->
                    <div class='form-group pb-2'>
                        <label class='form-label me-3'>Type de chauffage :</label>
                        <div class='form-check form-check-inline'>
                            <label for="fuel" class='form-check-label'>Fuel</label>
                            <input type="radio" name="energie" id="fuel" class='form-check-input'
                                   value="Fuel" <?php if ($ads['energie'] == 'Fuel') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="solaire" class='form-check-label'>Energie solaire</label>
                            <input type="radio" name="energie" id="solaire" class='form-check-input'
                                   value="Solaire" <?php if ($ads['energie'] == 'Solaire') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="gaz" class='form-check-label'>Gaz</label>
                            <input type="radio" name="energie" id="gaz" class='form-check-input'
                                   value="Gaz" <?php if ($ads['energie'] == 'Gaz') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="electrique" class='form-check-label'>Electrique</label>
                            <input type="radio" name="energie" id="electrique" class='form-check-input'
                                   value="Electrique" <?php if ($ads['energie'] == 'Electrique') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="bois" class='form-check-label'>Bois</label>
                            <input type="radio" name="energie" id="bois" class='form-check-input'
                                   value="Bois" <?php if ($ads['energie'] == 'Bois') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="autre" class="form-check-label">Autre</label>
                            <input type="radio" name="energie" id="autre" class="form-check-input"
                                   value="Autre" <?php if ($ads['energie'] == 'Autre') : ?> checked<?php endif ?>>
                        </div>
                    </div>
                    <!-- fin section energie -->

                    <div class='form-group pb-2'>
                        <label class="form-label me-3">Type logement* : </label>
                        <div class="form-check form-check-inline">
                            <label for="T1" class="form-check-label">T1</label>
                            <input type="radio" name="type" id="T1" class="form-check-input"
                                   value="T1" <?php if ($ads['type'] == 'T1') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T2" class='form-check-label'>T2</label>
                            <input type="radio" name="type" id="T2" class='form-check-input'
                                   value="T2" <?php if ($ads['type'] == 'T2') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T3" class='form-check-label'>T3</label>
                            <input type="radio" name="type" id="T3" class='form-check-input'
                                   value="T3" <?php if ($ads['type'] == 'T3') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T4" class='form-check-label'>T4</label>
                            <input type="radio" name="type" id="T4" class='form-check-input'
                                   value="T4" <?php if ($ads['type'] == 'T4') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T5" class='form-check-label'>T5</label>
                            <input type="radio" name="type" id="T5" class='form-check-input'
                                   value="T5" <?php if ($ads['type'] == 'T5') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T6" class='form-check-label'>T6</label>
                            <input type="radio" name="type" id="T6" class='form-check-input'
                                   value="T6" <?php if ($ads['type'] == 'T6') : ?> checked<?php endif ?>>
                        </div>
                    </div>

                    <div class="form-group pb-2">
                        <label for='superficie' class="form-label">Superficie*</label>
                        <div class='input-group'>
                            <input type='number' name='superficie' id="superficie" class="form-control" required
                                   min='10' max='9999' value="<?= esc($ads['superficie']) ?>"/>
                            <span class='input-group-text'>m<sup>2</sup></span>
                        </div>
                    </div>

                    <div class="form-group pb-2">
                        <label for='description' class="form-label">Description</label>
                        <textarea name='description' id="description" class="form-control" cols='45'
                                  rows='4'><?= esc($ads['description']) ?></textarea>
                    </div>

                    <div class="form-group pb-2">
                        <label for="adresse" class="form-label">Adresse*</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" required maxlength="128"
                               value="<?= esc($ads['adresse']) ?>"/>
                    </div>

                    <div class='row g-3 pb-2'>
                        <div class='form-group pb-2 col-md-6'>
                            <label for="ville" class='form-label'>Ville*</label>
                            <input type="text" name="ville" id="ville" class='form-control' required maxlength="128"
                                   value="<?= esc($ads['ville']) ?>"/>
                        </div>

                        <div class='form-group pb-2 col-md-6'>
                            <label for="cp" class='form-label'>Code postal*</label>
                            <input type="number" name="cp" id="cp" class="form-control" min="01000" max="99999" required minlength="5" maxlength="5"
                                   value="<?= esc($ads['cp']) ?>"/>
                        </div>
                    </div>

                <?php else : ?>

                    <div class='form-group pb-2'>
                        <label for='titre' class='form-label'>Titre*</label>
                        <input type='text' name='titre' id='titre' class='form-control' minlength='3' maxlength='128' required/>
                    </div>

                    <div class='row g-3'>
                        <div class='form-group pb-2 col-md-6'>
                            <label for='loyer' class='form-label'>Loyer*</label>
                            <div class='input-group'>
                                <input type='number' name='loyer' id='loyer' class='form-control' min='0' required/>
                                <span class='input-group-text'>€</span>
                            </div>
                        </div>

                        <div class='form-group pb-2 col-md-6'>
                            <label for='charges' class='form-label'>Charges</label>
                            <div class='input-group'>
                                <input type='number' name='charges' id='charges' class='form-control' min='0'/>
                                <span class='input-group-text'>€</span>
                            </div>
                        </div>
                    </div>

                    <div class='form-group pb-2'>
                        <label class='form-label me-3'>Chauffage* : </label>

                        <div class='form-check form-check-inline'>
                            <input type='radio' name='chauffage' id='collectif' class='form-check-input'
                                   value='Collectif' <?php if ($ads['chauffage'] == 'Collectif') : ?> checked<?php endif ?>>
                            <label for="collectif" class='form-check-label'>Collectif</label>
                        </div>

                        <div class='form-check form-check-inline'>
                            <input type='radio' name='chauffage' id="individuel" class="form-check-input"
                                   value='Individuel' <?php if ($ads['chauffage'] == 'Individuel') : ?> checked<?php endif ?>>
                            <label for="individuel" class='form-check-label'>Individuel</label>
                        </div>
                    </div>

                    <div class='form-group pb-2'>
                        <label class='form-label me-3'>Type de chauffage :</label>
                        <div class='form-check form-check-inline'>
                            <label for="fuel" class='form-check-label'>Fuel</label>
                            <input type="radio" name="energie" id="fuel" class='form-check-input'
                                   value="Fuel" <?php if ($ads['energie'] == 'Fuel') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="solaire" class='form-check-label'>Energie solaire</label>
                            <input type="radio" name="energie" id="solaire" class='form-check-input'
                                   value="Solaire" <?php if ($ads['energie'] == 'Solaire') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="gaz" class='form-check-label'>Gaz</label>
                            <input type="radio" name="energie" id="gaz" class='form-check-input'
                                   value="Gaz" <?php if ($ads['energie'] == 'Gaz') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="electrique" class='form-check-label'>Electrique</label>
                            <input type="radio" name="energie" id="electrique" class='form-check-input'
                                   value="Electrique" <?php if ($ads['energie'] == 'Electrique') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="bois" class='form-check-label'>Bois</label>
                            <input type="radio" name="energie" id="bois" class='form-check-input'
                                   value="Bois" <?php if ($ads['energie'] == 'Bois') : ?> checked<?php endif ?>>
                        </div>
                        <div class='form-check form-check-inline'>
                            <label for="autre" class="form-check-label">Autre</label>
                            <input type="radio" name="energie" id="autre" class="form-check-input"
                                   value="Autre" <?php if ($ads['energie'] == 'Autre') : ?> checked<?php endif ?>>
                        </div>
                    </div>

                    <div class='form-group pb-2'>
                        <label class="form-label me-3">Type logement* : </label>
                        <div class="form-check form-check-inline">
                            <label for="T1" class="form-check-label">T1</label>
                            <input type="radio" name="type" id="T1" class="form-check-input"
                                   value="T1" <?php if ($ads['type'] == 'T1') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T2" class='form-check-label'>T2</label>
                            <input type="radio" name="type" id="T2" class='form-check-input'
                                   value="T2" <?php if ($ads['type'] == 'T2') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T3" class='form-check-label'>T3</label>
                            <input type="radio" name="type" id="T3" class='form-check-input'
                                   value="T3" <?php if ($ads['type'] == 'T3') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T4" class='form-check-label'>T4</label>
                            <input type="radio" name="type" id="T4" class='form-check-input'
                                   value="T4" <?php if ($ads['type'] == 'T4') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T5" class='form-check-label'>T5</label>
                            <input type="radio" name="type" id="T5" class='form-check-input'
                                   value="T5" <?php if ($ads['type'] == 'T5') : ?> checked<?php endif ?>>
                        </div>

                        <div class='form-check form-check-inline'>
                            <label for="T6" class='form-check-label'>T6</label>
                            <input type="radio" name="type" id="T6" class='form-check-input'
                                   value="T6" <?php if ($ads['type'] == 'T6') : ?> checked<?php endif ?>>
                        </div>
                    </div>

                    <div class="form-group pb-2">
                        <label for='superficie' class="form-label">Superficie*</label>
                        <div class='input-group'>
                            <input type='number' name='superficie' id="superficie" class="form-control" required
                                   min='10' max='9999'/>
                            <span class='input-group-text'>m<sup>2</sup></span>
                        </div>
                    </div>

                    <div class="form-group pb-2">
                        <label for='description' class="form-label">Description</label>
                        <textarea name='description' id="description" class="form-control" cols='45' rows='4'></textarea>
                    </div>

                    <div class="form-group pb-2">
                        <label for="adresse" class="form-label">Adresse*</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" required maxlength="128"/>
                    </div>

                    <div class='row g-3 pb-2'>
                        <div class='form-group pb-2 col-md-6'>
                            <label for="ville" class='form-label'>Ville*</label>
                            <input type="text" name="ville" id="ville" class='form-control' required maxlength="128"/>
                        </div>

                        <div class='form-group pb-2 col-md-6'>
                            <label for="cp" class='form-label'>Code postal*</label>
                            <input type="number" name="cp" id="cp" class="form-control" min="01000" max="99999" required
                                   minlength="5" maxlength="5"/>
                        </div>
                    </div>
                <?php endif ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <input type='submit' name='submit' value='Enregistrer' class='btn btn-secondary w-100'/>
                    </div>

                    <div class='col-md-6'>
                        <input type='submit' name='submit' value='Publier' class='btn btn-dark w-100'/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>
