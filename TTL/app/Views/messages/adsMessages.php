<!-- Les annonces qui ont des messages -->

<h2><?= esc($tete) ?></h2>
<div>
    <div style="border: thin solid black">
        <?php if (!empty($ads) && is_array($ads)) : ?>

            <!-- SECTION MESSAGES NON LU -->
            <div>
                <h3>non lus</h3>
                <?php foreach ($ads as $ads_item => $v) : ?>
                    <!-- Les annonce n'apparaissent que si elles ont au moins un message non lu -->
                    <?php if ($v['unread']['hasnewmsg']) : ?>
                        <!-- Div d'une annonce -->
                        <div style="border: thin solid blue">

                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($v['A_idannonce'], 'url') ?>">
                                <strong><?= esc($v['A_titre']) ?></strong></a>
                            

                            <!-- Div de gauche -->
                            <div>
                                <!-- Montant du loyer charges inclues -->
                                <?php echo (esc($v['A_cout_loyer'])) + (esc($v['A_cout_charges'])) ?> € <em>tcc</em><br />
                                <!-- Type et surface -->
                                <?= esc($v['T_type']) ?> - <?= esc($v['A_superficie']) ?>m<sup>2</sup><br />
                                <!-- Code postal et ville -->
                                <?= esc($v['A_CP']) ?> <?= esc($v['A_ville']) ?><br />
                                <br />
                            </div><!-- fin div de gauche -->

                            <!-- Div de droite -->
                            <div>

                            </div><!-- fin div de droite -->
                            <!-- Icone notifiant des messages non lu-->
                            <?php if ($v['unread']['hasnewmsg'] > 0) : ?>
                                <?php if ($v['unread']['count'] > 1) : ?>
                                    <?= esc($v['unread']['count']) ?> Messages non lus :<br />
                                <?php else : ?>
                                    <?= esc($v['unread']['count']) ?> Message non lu :<br />
                                <?php endif ?>
                            <?php endif ?>
                            <div>
                                <?php foreach ($v['msg'] as $elem) : ?>
                                    <!-- les messages appartenant à cette annonce -->
                                    <?php if ($elem['A_idannonce'] === $v['A_idannonce']) : ?>

                                        de : <a title="Lire le message" href="/adsMessages/<?= esc($elem['M_idmessage'], 'url') ?>">
                                            <strong><?= $elem['U_mail'] ?></strong>
                                            <!-- Si le message est non lu il a une pastille de notification-->
                                            <?php if ($elem['M_lu'] == false) : ?>
                                                <?php echo '<sup>  <img src="' . base_url('red.png') . '"alt="icone message" width="10px" height="10px"/></sup>' ?>
                                            <?php endif ?></a><br />
                                        <sup> le <?= esc($elem['M_dateheure_message']) ?></sup><br />
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </div>
                        </div><!-- fin div de l'annonce -->

                    <?php endif ?>
                <?php endforeach; ?>
            </div>
            <!-- FIN SECTION ANNONCE AVEC MESSAGE NON LU -->

             <!-- SECTION MESSAGES -->
             <div>
                <h3>Vos messages</h3>
                <?php foreach ($ads as $ads_item => $v) : ?>
                    <!-- Les annonces n'apparaissent ici que si elles ne contienent pas de message non lu -->
                    <?php if (($v['nbmessage'] > 0) && (!$v['unread']['hasnewmsg'])) : ?>

                        <!-- Div d'une annonce -->
                        <div style="border: thin solid blue">
                            
                            <!-- Titre et Lien vers le détail de l'annonce -->
                            <a title="Détail de l'annonce" href="/ads/<?= esc($v['A_idannonce'], 'url') ?>">
                                <strong><?= esc($v['A_titre']) ?></strong></a><br/>
                            Liste des messages : <br />

                            <?php foreach ($v['msg'] as $msg) : ?>
                                <!-- Si l'annonce a des message, et qu'ils sont déjà lu -->
                                <?php if ($msg['A_idannonce'] === $v['A_idannonce']) : ?>
                                    de : <a title="Lire le message" href="/adsMessages/<?= esc($msg['M_idmessage'], 'url') ?>">
                                    <strong><?= $elem['U_mail'] ?></strong></a><br />
                                    <sup> le <?= esc($elem['M_dateheure_message']) ?></sup><br />
                                <?php endif ?>
                            <?php endforeach; ?>
                        </div><!-- fin div de l'annonce -->
                    <?php endif ?>

                <?php endforeach; ?>

            </div>
            <!-- FIN SECTION MESSAGE -->

        <?php endif ?>
    </div>
</div>