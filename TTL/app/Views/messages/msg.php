<div style="border: thin solid blue">

    de : <a title="Détail" href="/users/<?= esc($sentby, 'url') ?>">
        <?= esc($sentby) ?> </a><br />
    <sup><?= esc($msg['M_dateheure_message']) ?></sup><br />

    message :<br />
    <div>
        <?= esc($msg['M_texte_message']) ?>
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
        <input type="hidden" name="idAnnonce" value=<?= esc($msg['A_idannonce']) ?> />
        <input type="hidden" name="idUser" value=<?= esc($msg['U_mail']) ?> />
        <input type="hidden" name="idmsg" value=<?= esc($msg['M_idmessage']) ?> />
    </form>
</div>