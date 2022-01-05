<h2><?= esc($tete) ?></h2>
<!-- TODO debug à virer -->
messages/messages.php<br />
<div style="border: thin solid black">
    <?php if (!empty($messages) && is_array($messages)) : ?>
        <!-- SECTION messages non lus -->
        <div>
            <h3>Vos messages non lus</h3>
            <?php foreach ($messages as $k => $v) : ?>
                <?php if ((esc($v['U_mail']) != $iduser) && (esc($v['M_lu']) != 0)) : ?>
                    <!-- Div d'un message -->
                    <!-- l'indice 0 contient le pseudo -->
                    <div style="border: thin solid blue">

                        de : <a title="Détail" href="/users/<?= esc($v[0], 'url') ?>">
                            <?= esc($v[0]) ?> </a><br />
                        <sup><?= esc($v['M_dateheure_message']) ?></sup><br />

                        message :<br />
                        <div>
                            <?= esc($v['M_texte_message']) ?>
                        </div>
                        <br />
                        <form action="actionMessage" method="post">
                            <?= csrf_field() ?>
                            répondre : <br />
                            <textarea name="message" cols="40" rows="2"></textarea><br />
                            <br />
                            <input type="submit" name="act" value="Repondre" />
                            <input type="submit" name="act" value="Lire" /><br />
                            <br />
                            <input type="hidden" name="idAnnonce" value=<?= esc($v['A_idannonce']) ?> />
                            <input type="hidden" name="idUser" value=<?= esc($v['U_mail']) ?> />
                            <input type="hidden" name="idmsg" value=<?= esc($v['M_idmessage']) ?> />
                        </form>
                    </div>

                <?php endif ?>
            <?php endforeach ?>
        </div>
        <!-- FIN SECTION messages non lus -->


        <!-- SECTION messages reçus -->
        <div>
            <h3>Vos messages reçus</h3>
            <?php foreach ($messages as $k => $v) : ?>
                <?php if ((esc($v['U_mail']) != $iduser) && (esc($v['M_lu']) != 0)) : ?>
                    <!-- Div d'un message -->
                    <!-- l'indice 0 contient le pseudo -->
                    <div style="border: thin solid blue">

                        de : <a title="Détail" href="/users/<?= esc($v[0], 'url') ?>">
                            <?= esc($v[0]) ?> </a><br />
                        <sup><?= esc($v['M_dateheure_message']) ?></sup><br />

                        message :<br />
                        <div>
                            <?= esc($v['M_texte_message']) ?>
                        </div>
                        <br />
                        <form action="actionMessage" method="post">
                            <?= csrf_field() ?>
                            répondre : <br />
                            <textarea name="message" cols="40" rows="2"></textarea><br />
                            <br />
                            <input type="submit" name="act" value="Repondre" />
                            <input type="submit" name="act" value="Lire" /><br />
                            <br />
                            <input type="hidden" name="idAnnonce" value=<?= esc($v['A_idannonce']) ?> />
                            <input type="hidden" name="idUser" value=<?= esc($v['U_mail']) ?> />
                            <input type="hidden" name="idmsg" value=<?= esc($v['M_idmessage']) ?> />
                        </form>
                    </div>

                <?php endif ?>
            <?php endforeach ?>
        </div>
        <!-- FIN SECTION messages reçus -->

        <!--  SECTION messages envoyés -->
        <div>
            <h3>Vos messages envoyés</h3>
            <?php foreach ($messages as $k => $v) : ?>
                <?php if (esc($v['U_mail']) === $iduser) : ?>
                    <!-- Div d'un message -->
                    <!-- l'indice 0 contient le pseudo -->
                    <div style="border: thin solid blue">

                        à: <a title="Détail" href="/users/<?= esc($v[0], 'url') ?>">
                            <?= esc($v[0]) ?> </a><br />
                        <sup><?= esc($v['M_dateheure_message']) ?></sup><br />

                        message :<br />
                        <div>
                            <?= esc($v['M_texte_message']) ?>
                        </div>
                        <br />
                        <form action="actionMessage" method="post">
                            <?= csrf_field() ?>
                            répondre : <br />
                            <textarea name="message" cols="40" rows="2"></textarea><br />
                            <br />
                            <input type="submit" name="act" value="Repondre" />
                            <input type="submit" name="act" value="Lire" /><br />
                            <br />
                            <input type="hidden" name="idAnnonce" value=<?= esc($v['A_idannonce']) ?> />
                            <input type="hidden" name="idUser" value=<?= esc($v['U_mail']) ?> />
                            <input type="hidden" name="idmsg" value=<?= esc($v['M_idmessage']) ?> />
                        </form>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        <!-- FIN SECTION messages reçus -->

    <?php endif ?>
</div>