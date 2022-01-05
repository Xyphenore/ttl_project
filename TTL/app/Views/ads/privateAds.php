<?php
//Affichage de toutes les annonces publiées ou non sur le site n'est visible que par l'utilisateur les ayant créées
?>

<!-- TODO debug à virer -->
ads/privateAds.php<br />

<section class="container my-3">
    <h1 class="fs-3">Vos annonces</h1>

    <div class="border border-secondary rounded-3 p-4">
    <?php if (!empty($ads) && is_array($ads)) : ?>
        <div class="border border-primary rounded-3 py-3 my-3">
            <h2 class="fs-4 mx-4">Annonces publiées</h2>

            <hr>

            <div class="px-4">
                <?php foreach ($ads as $ads_item) : ?>
                    <?php if ($ads_item['A_etat'] === 'Public') : ?>
                        <!-- Div d'une annonce -->
                        <div class='border border-secondary bg-secondary text-white rounded-3 p-3 mb-3'>

                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>" class='text-white fs-3 me-2'>
                                <?= esc($ads_item['A_titre']) ?>
                            </a>


                            <!-- Icone Si l'annonce a des messages -->
                            <?php if ($ads_item['count'] > 0) : ?>
                               
                               <?php echo '<img src="' . base_url('red.png') . '"alt="icone message" width="20px" height="20px"/>' ?>

                               <?php if ($ads_item['count'] > 1) : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Messages non lus </a>
                               <?php else : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Message non lu </a>
                               <?php endif ?>
                           <?php endif ?>

                            <div class='row g-3 py-2'>
                            <!-- Div de gauche -->
                                <div class='col-5'>
                                <!-- Photo principale de l'annonce -->
                                <?php if (!empty($ads_item['P_idphoto'])) : ?>
                                    <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '"width ="100px" height ="80px"/>' ?><br />
                                <?php else : ?>
                                    <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?><br />
                                <?php endif ?>


                            </div><!-- fin div de gauche -->

                            <!-- Div de droite -->
                                <div class='col-7'>

                                    <h3 class='fs-4'>Informations</h3>

                                    <ul class='ps-2 list-unstyled'>
                                        <li>
                                            <!-- Montant du loyer charges inclues -->
                                            <?php echo (esc($ads_item['A_cout_loyer'])) + (esc($ads_item['A_cout_charges'])) ?>
                                            € <em>tcc</em>
                                        </li>
                                        <li>
                                            <!-- Type et surface -->
                                            <?= esc($ads_item['T_type']) ?> - <?= esc($ads_item['A_superficie']) ?>
                                            m<sup>2</sup>
                                        </li>
                                        <li>
                                            <!-- Code postal et ville -->
                                            <?= esc($ads_item['A_CP']) ?> <?= esc($ads_item['A_ville']) ?>
                                        </li>
                                    </ul>
                                </div><!-- fin div de droite -->

                            </div>

                                <hr>

                                <div>
                                    <ul class='list-unstyled'>
                                        <li>Créée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                        <li>Editée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                    </ul>
                                </div>


                            <!-- TODO virer debug -->
                            <sup>debug : <?= esc($ads_item['A_etat']) ?> <?= esc($ads_item['A_idannonce']) ?>
                                <br/></sup>

                            <form action="actionAds" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value=<?= esc($ads_item['A_idannonce']) ?>/>

                                <input type="submit" name="act" value="Voir" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Archiver" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Brouillon" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Modifier" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Supprimer" class='btn btn-danger text-white mb-1'/>
                            </form>
                        </div><!-- fin div de l'annonce -->

                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class='border border-primary rounded-3 py-3 my-3'>
            <h2 class='fs-4 mx-4'>Annonces sauvegardées</h2>

            <hr>

            <div class='px-4'>
                <?php foreach ($ads as $ads_item) : ?>
                    <?php if ($ads_item['A_etat'] === 'Brouillon') : ?>
                        <!-- Div d'une annonce -->
                        <div class="border border-secondary bg-secondary text-white rounded-3 p-3 mb-3">

                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>" class="text-white fs-3 me-2">
                                <?= esc($ads_item['A_titre']) ?>
                            </a>


                            <!-- Icone Si l'annonce a des messages -->
                            <?php if ($ads_item['count'] > 0) : ?>
                               
                               <?php echo '<img src="' . base_url('red.png') . '"alt="icone message" width="20px" height="20px"/>' ?>

                               <?php if ($ads_item['count'] > 1) : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Messages non lus </a>
                               <?php else : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Message non lu </a>
                               <?php endif ?>
                           <?php endif ?>

                            <div class="row g-3 py-2">
                            <!-- Div de gauche -->
                                <div class="col-5">
                                    <!-- Photo principale de l'annonce -->
                                    <?php if (!empty($ads_item['P_idphoto'])) : ?>
                                        <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '" class="w-100"/>' ?>
                                    <?php else : ?>
                                        <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?>
                                    <?php endif ?>
                                </div><!-- fin div de gauche -->

                                <!-- Div de droite -->
                                <div class="col-7">

                                    <h3 class="fs-4">Informations</h3>

                                    <ul class="ps-2 list-unstyled">
                                        <li>
                                            <!-- Montant du loyer charges inclues -->
                                            <?php echo (esc($ads_item['A_cout_loyer'])) + (esc($ads_item['A_cout_charges'])) ?>
                                            € <em>tcc</em><br/>
                                        </li>
                                        <li>
                                            <!-- Type et surface -->
                                            <?= esc($ads_item['T_type']) ?> - <?= esc($ads_item['A_superficie']) ?>m<sup>2</sup><br/>
                                        </li>
                                        <li>
                                            <!-- Code postal et ville -->
                                            <?= esc($ads_item['A_CP']) ?> <?= esc($ads_item['A_ville']) ?><br/>
                                        </li>
                                    </ul>
                                </div><!-- fin div de droite -->
                            </div>

                            <hr>

                            <div>
                                <ul class="list-unstyled">
                                    <li>Créée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                    <li>Editée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                </ul>
                            </div>



                            <!-- TODO virer debug -->
                            <sup>debug : <?= esc($ads_item['A_etat']) ?> <?= esc($ads_item['A_idannonce']) ?>
                                <br/></sup>

                            <form action="actionAds" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value=<?= esc($ads_item['A_idannonce']) ?>/>

                                <input type="submit" name="act" value="Voir" class="btn btn-dark text-white mb-1"/>
                                <input type="submit" name="act" value="Archiver" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Publier" class='btn btn-success text-white mb-1'/>
                                <input type="submit" name="act" value="Modifier" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Supprimer" class='btn btn-danger text-white mb-1'/>
                            </form>
                        </div><!-- fin div de l'annonce -->
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class='border border-primary rounded-3 py-3 my-3'>
            <h2 class='fs-4 mx-4'>Annonces archivées</h2>

            <hr>

            <div class='px-4'>
                <?php foreach ($ads as $ads_item) : ?>
                    <?php if ($ads_item['A_etat'] === 'Archive') : ?>
                        <!-- Div d'une annonce -->
                        <div class='border border-secondary bg-secondary text-white rounded-3 p-3 mb-3'>

                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>" class='text-white fs-3 me-2'>
                                <?= esc($ads_item['A_titre']) ?>
                            </a>

                             <!-- Icone Si l'annonce a des messages -->
                            <?php if ($ads_item['count'] > 0) : ?>
                               
                               <?php echo '<img src="' . base_url('red.png') . '"alt="icone message" width="20px" height="20px"/>' ?>

                               <?php if ($ads_item['count'] > 1) : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Messages non lus </a>
                               <?php else : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Message non lu </a>
                               <?php endif ?>
                           <?php endif ?>

                            <div class='row g-3 py-2'>
                                <!-- Div de gauche -->
                                <div class='col-5'>
                                    <!-- Photo principale de l'annonce -->
                                    <?php if (!empty($ads_item['P_idphoto'])) : ?>
                                        <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '" class="w-100"/>' ?>
                                    <?php else : ?>
                                        <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?>
                                    <?php endif ?>
                                
                                </div><!-- fin div de gauche -->

                                <!-- Div de droite -->
                                <div class='col-7'>
                                    <h3 class='fs-4'>Informations</h3>

                                    <ul class='ps-2 list-unstyled'>
                                        <li>
                                            <!-- Montant du loyer charges inclues -->
                                            <?php echo (esc($ads_item['A_cout_loyer'])) + (esc($ads_item['A_cout_charges'])) ?>
                                            € <em>tcc</em><br/>
                                        </li>
                                        <li>
                                            <!-- Type et surface -->
                                            <?= esc($ads_item['T_type']) ?> - <?= esc($ads_item['A_superficie']) ?>
                                            m<sup>2</sup><br/>
                                        </li>
                                        <li>
                                            <!-- Code postal et ville -->
                                            <?= esc($ads_item['A_CP']) ?> <?= esc($ads_item['A_ville']) ?><br/>
                                        </li>
                                    </ul>
                                </div><!-- fin div de droite -->
                            </div>

                            <hr>

                            <div>
                                <ul class='list-unstyled'>
                                    <li>Créée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                    <li>Editée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                </ul>
                            </div>


                            <!-- TODO virer debug -->
                            <sup>debug : <?= esc($ads_item['A_etat']) ?> <?= esc($ads_item['A_idannonce']) ?>
                                <br/></sup>

                            <form action="actionAds" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value=<?= esc($ads_item['A_idannonce']) ?>/>

                                <input type="submit" name="act" value="Voir" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Supprimer" class='btn btn-danger text-white mb-1'/>
                            </form>
                        </div><!-- fin div de l'annonce -->
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class='border border-primary rounded-3 py-3 my-3'>
            <h2 class='fs-4 mx-4'>Annonces bloquées</h2>

            <hr>

            <div class='px-4'>
                <?php foreach ($ads as $ads_item) : ?>
                    <?php if ($ads_item['A_etat'] === 'Bloc') : ?>
                        <!-- Div d'une annonce -->
                        <div class='border border-secondary bg-secondary text-white rounded-3 p-3 mb-3'>

                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($ads_item['A_idannonce'], 'url') ?>"  class='text-white fs-3 me-2'>
                                <?= esc($ads_item['A_titre']) ?>
                            </a>

                            <!-- Icone Si l'annonce a des messages -->
                            <?php if ($ads_item['count'] > 0) : ?>
                               
                               <?php echo '<img src="' . base_url('red.png') . '"alt="icone message" width="20px" height="20px"/>' ?>

                               <?php if ($ads_item['count'] > 1) : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Messages non lus </a>
                               <?php else : ?>
                                   <a title="voir les messages" href="/adsMessages"  class='text-white'><?= esc($ads_item['count']) ?> Message non lu </a>
                               <?php endif ?>
                           <?php endif ?>

                            <div class='row g-3 py-2'>
                            <!-- Div de gauche -->
                            <div class='col-5'>
                                    <!-- Photo principale de l'annonce -->
                                    <?php if (!empty($ads_item['P_idphoto'])) : ?>
                                        <?php echo '<img src = "data:image/png;base64,' . base64_encode($ads_item['P_data']) . '" alt="' . ($ads_item['P_titre']) . '" class="w-100"/>' ?>
                                    <?php else : ?>
                                        <?php echo '<img src="' . base_url('no_pic.png') . '"alt="Photo par défaut" width="100px" height="80px"/>' ?>
                                    <?php endif ?>
                                
                                </div><!-- fin div de gauche -->

                            <!-- Div de droite -->
                                <div class='col-7'>
                                    <h3 class='fs-4'>Informations</h3>

                                    <ul class='ps-2 list-unstyled'>
                                        <li>
                                            <!-- Montant du loyer charges inclues -->
                                            <?php echo (esc($ads_item['A_cout_loyer'])) + (esc($ads_item['A_cout_charges'])) ?>
                                            € <em>tcc</em><br/>
                                        </li>
                                        <li>
                                            <!-- Type et surface -->
                                            <?= esc($ads_item['T_type']) ?> - <?= esc($ads_item['A_superficie']) ?>
                                            m<sup>2</sup><br/>
                                        </li>
                                        <li>
                                            <!-- Code postal et ville -->
                                            <?= esc($ads_item['A_CP']) ?> <?= esc($ads_item['A_ville']) ?><br/>
                                        </li>
                                    </ul>
                                </div><!-- fin div de droite -->
                            </div>

                            <div>
                                <ul class='list-unstyled'>
                                    <li>Créée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                    <li>Editée le : <?= esc($ads_item['A_date_creation']) ?></li>
                                </ul>
                            </div>


                            <!-- TODO virer debug -->
                            <sup>debug : <?= esc($ads_item['A_etat']) ?> <?= esc($ads_item['A_idannonce']) ?>
                                <br/></sup>

                            <form action="actionAds" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value=<?= esc($ads_item['A_idannonce']) ?>/>

                                <input type="submit" name="act" value="Voir" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Modifier" class='btn btn-dark text-white mb-1'/>
                                <input type="submit" name="act" value="Supprimer" class='btn btn-danger text-white mb-1'/>
                            </form>
                        </div><!-- fin div de l'annonce -->
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <div class='border border-primary rounded-3 py-3 my-3'>
            <h2 class="fs-4 mx-4">Aucune annonce</h2>

            <hr>

            <p>Aucune annonce en ligne actuellement</p>
        </div>
    <?php endif ?>
    </div>
</section>
