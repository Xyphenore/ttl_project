<div style="border: thin solid blue">

de : <a title="Détail" href="/users/<?= esc($sentby, 'url') ?>">
        <?= esc($sentby) ?> </a><br />
    <?= esc($msg['M_dateheure_message']) ?><br />

    message :<br />
    <div>
        <?= esc($msg['M_texte_message']) ?>
    </div>
    <br />

</div>